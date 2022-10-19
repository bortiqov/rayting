<?php
/**
 * @author Izzat <i.rakhmatov@list.ru>
 * @package payment
 */

namespace rakhmatov\payment\controllers;


use common\models\User;
use rakhmatov\payment\components\PaymentController;
use rakhmatov\payment\dto\PaymentHistoryDTO;
use rakhmatov\payment\exceptions\ClickException;
use rakhmatov\payment\models\PaymentHistory;
use rakhmatov\payment\models\ClickRequest;
use rakhmatov\payment\models\ClickResponse;
use rakhmatov\payment\models\Transaction;
use yii\rest\Controller;

class ClickController extends PaymentController
{

    const ACTION_PREPARE = 0;
    const ACTION_PERFORM = 1;

    public $request;

    public $response;

    private $config;

    public $service_id;
    public $secret_key;

    public $messages = [
        0 => "Success",
        1 => "SIGN CHECK FAILED!",
        2 => "Incorrect parameter amount",
        3 => "Action not found",
        4 => "Already paid",
        5 => "User does not exist",
        6 => "Transaction does not exist",
        7 => "Failed to update user",
        8 => "Error in request from click",
        9 => "Transaction cancelled",
    ];

    /**
     * DefaultController constructor.
     * @param $id
     * @param $module
     * @param array $config
     * @throws ClickException
     */
    public function __construct($id, $module, $config = [])
    {
        $this->request = new ClickRequest();
        $this->response = new ClickResponse($this->request);
        $this->id = $id;
        $this->module = $module;
        $this->config = $config;

        $this->service_id = \Yii::$app->params['click']['service_id'];
        $this->secret_key = \Yii::$app->params['click']['secret_key'];
    }

    public function validateRequest()
    {
        return isset($this->request->data['params']['click_trans_id'])
            && isset($this->request->data['params']['service_id'])
            && isset($this->request->data['params']['merchant_trans_id'])
            && isset($this->request->data['params']['amount'])
            && isset($this->request->data['params']['action'])
            && isset($this->request->data['params']['sign_string']);
    }

    public function authorize()
    {
        return $this->request->data['params']['sign_string'] == md5($this->request->data['params']['click_trans_id']
                . $this->service_id
                . $this->secret_key
                . $this->request->data['params']['merchant_trans_id']
                . (array_key_exists('merchant_prepare_id', $this->request->data['params'])
                    ? $this->request->data['params']['merchant_prepare_id'] : '')
                . $this->request->data['params']['amount']
                . $this->request->data['params']['action']
                . $this->request->data['params']['sign_time']);
    }

    public function actionIndex()
    {
        if ($this->request->data['params']['error'] == "-5017") {
            $this->createTransaction();
            return;
        }

        if (!$this->validateRequest()) {
            $this->response->error([
                "error" => -8,
                "error_note" => $this->messages[8]
            ]);
        }

        if (!User::findOne($this->request->data['params']['merchant_trans_id'])) {
            $this->response->error([
                "error" => -5,
                "error_note" => $this->messages[5]
            ]);
        }

        switch ($this->request->data['params']['action']) {
            case self::ACTION_PREPARE:
                $this->createTransaction();
                break;
            case self::ACTION_PERFORM:
                $this->performTransaction();
                break;
            default:
                $this->response->error([
                    'error' => -3,
                    'error_note' => $this->messages[3]
                ]);
                break;

        }

    }

    public function checkPerformTransaction()
    {
        // TODO: Implement checkPerformTransaction() method.
    }

    public function checkTransaction()
    {
        // TODO: Implement checkTransaction() method.
    }

    public function createTransaction()
    {
        if ($this->authorize()) {
            if (!Transaction::findOne(['transaction_id' => $this->request->data['params']['click_trans_id']])) {
                $transaction = new Transaction([
                    'transaction_id' => $this->request->data['params']['click_trans_id'],
                    'time' => time(),
                    'state' => Transaction::STATE_CANCELLED,
                    'amount' => $this->request->data['params']['amount'] * 100,
                    'user_id' => $this->request->data['params']['merchant_trans_id'],
                ]);

                if ($transaction->save()) {
                    $this->response->send([
                        'error' => 0,
                        'error_note' => $this->messages[0],
                        'click_trans_id' => $this->request->data['params']["click_trans_id"],
                        'merchant_trans_id' => $this->request->data['params']["merchant_trans_id"],
                        'merchant_prepare_id' => $transaction->id,
                    ]);
                } else {
                    $this->response->error([
                        'error' => ClickException::ERROR_USER_NOT_FOUND,
                        'error_note' => $this->messages[5]
                    ]);
                }
            } else {
                $this->response->error([
                    'error' => ClickException::ERROR_ALREADY_PAID,
                    'error_note' => $this->messages[4]
                ]);
            }
        } else {
            $this->response->error([
                'error' => ClickException::ERROR_SIGN_CHECH_FAILED,
                'error_note' => $this->messages[1]
            ]);
        }
    }

    public function performTransaction()
    {
        if ($this->authorize()) {

            if ($transaction = Transaction::findOne(['transaction_id' => $this->request->data['params']['click_trans_id']])) {
                $transaction->state = Transaction::STATE_COMPLETED;
                $transaction->time = time();
                if ($transaction->save()) {
                    PaymentHistory::add(new PaymentHistoryDTO([
                        'user_id' => $transaction->user_id,
                        'payment_type' => PaymentHistory::PAYMENT_TYPE_CLICK,
                        'amount' => $transaction->amount / 100,
                        'transaction_id' => $transaction->id,
                    ]));

                    $this->response->send([
                        'error' => 0,
                        'error_note' => $this->messages[0],
                        'click_trans_id' => $transaction->transaction_id,
                        'merchant_trans_id' => $transaction->user_id,
                        'merchant_confirm_id' => $transaction->id,
                    ]);

                } else {
                    $this->response->error([
                        'error' => ClickException::ERROR_USER_NOT_FOUND,
                        'error_note' => $this->messages[5]
                    ]);
                }
            } else {
                $this->response->error([
                    'error' => ClickException::ERROR_TRANSACTION_NOT_FOUND,
                    'error_note' => $this->messages[6]
                ]);
            }
        } else {
            $this->response->error([
                'error' => ClickException::ERROR_SIGN_CHECH_FAILED,
                'error_note' => $this->messages[1]
            ]);
        }
    }

    public function cancelTransaction()
    {
        if ($transaction = Transaction::findOne(['transaction_id' => $this->request->data['params']['click_trans_id']]) instanceof Transaction) {

            $transaction->cancel();

            PaymentHistory::add(new PaymentHistoryDTO([
                'user_id' => $transaction->user_id,
                'payment_type' => PaymentHistory::PAYMENT_CANCELLED_TYPE_CLICK,
                'amount' => -($transaction->amount / 100),
                'transaction_id' => $transaction->id,
            ]));

            $this->response->send([
                "error" => -9,
                "error_note" => $this->messages[9],
                'click_trans_id' => $this->request->data['params']["click_trans_id"],
                'merchant_trans_id' => $this->request['params']["merchant_trans_id"],
                'merchant_prepare_id' => $this->request['params']["merchant_prepare_id"],
            ]);
        } else {
            $this->response->error([
                'error' => -6,
                'error_note' => $this->messages[6]
            ]);
        }
    }

    public function changePassword()
    {
        // TODO: Implement changePassword() method.
    }

}

?>