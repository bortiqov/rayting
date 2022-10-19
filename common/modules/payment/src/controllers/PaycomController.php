<?php
/**
 * @author Izzat <i.rakhmatov@list.ru>
 * @package payment
 */

namespace rakhmatov\payment\controllers;


use common\modules\waiter\models\Waiter as User;
use rakhmatov\payment\components\PaymentController;
use rakhmatov\payment\dto\PaymentHistoryDTO;
use rakhmatov\payment\exceptions\PaycomException;
use rakhmatov\payment\models\PaymentHistory;
use rakhmatov\payment\models\PaycomRequest;
use rakhmatov\payment\models\PaycomResponse;
use rakhmatov\payment\models\Transaction;
use yii\rest\Controller;

class PaycomController extends PaymentController
{

    public $request;

    public $response;
    /**
     * @var array
     */
    private $config;

    /**
     * DefaultController constructor.
     * @param $id
     * @param $module
     * @param array $config
     * @throws PaycomException
     */
    public function __construct($id, $module, $config = [])
    {
        $this->request = new PaycomRequest();
        $this->response = new PaycomResponse($this->request);
        $this->id = $id;
        $this->module = $module;
        $this->config = $config;
    }


    /**
     * @param $request_id
     * @throws PaycomException
     */
    public function authorize()
    {
        if (
            !\Yii::$app->request->getHeaders()->get('Authorization')
            || !preg_match('/^s*Basic\s+(\S+)\s*$/i', \Yii::$app->request->getHeaders()->get('Authorization'), $matches)
            || base64_decode($matches[1]) != \Yii::$app->params['paycom']['login'] . ":" . \Yii::$app->params['paycom']['test_key']
        ) {
            throw new PaycomException(
                $this->request->id,
                'Insufficient privilege to perform this method.',
                PaycomException::ERROR_INSUFFICIENT_PRIVILEGE
            );
        }

        return true;
    }

    /**
     * @throws PaycomException
     */
    public function actionIndex()
    {
        if (
            !\Yii::$app->request->getHeaders()->get('Authorization')
            || !preg_match('/^s*Basic\s+(\S+)\s*$/i', \Yii::$app->request->getHeaders()->get('Authorization'), $matches)
            || base64_decode($matches[1]) != \Yii::$app->params['paycom']['login'] . ":" . \Yii::$app->params['paycom']['test_key']
        ) {
            return (new PaycomException(
                $this->request->id,
                'Insufficient privilege to perform this method.',
                PaycomException::ERROR_INSUFFICIENT_PRIVILEGE
            ));
        }
 
        try {
            if (method_exists($this, lcfirst($this->request->data['method']))) {
                return $this->{lcfirst($this->request->data['method'])}();
            } else {
                $this->response->error(
                    PaycomException::ERROR_METHOD_NOT_FOUND,
                    'Method not found.',
                    $this->request->data['method']
                );
            }
        } catch (PaycomException $e) {
            return $e->getError();
        }
    }

    public function checkPerformTransaction()
    {

        $user = User::findOne($this->request->data['params']['account']['user_id']);

        if (!$user instanceof User) {
            $this->response->error(
                PaycomException::ERROR_INVALID_ACCOUNT,
                'Account not found.'
            );
            return;
        }

        $transaction = Transaction::find()->where([
            'transaction_id' => $this->request->id,
            'user_id' => $this->request->data['params']['account']['user_id']
        ])->one();

        if ($transaction instanceof Transaction) {
            $this->response->error(
                PaycomException::ERROR_COULD_NOT_PERFORM,
                'There is other active/complated transaction for this order.'
            );
	}

	if ($this->request->data['params']['amount'] < 1000 || $this->request->data['params']['amount'] > 100000000) {
		return $this->response->error(PaycomException::ERROR_INVALID_AMOUNT, 'Amount error');
	}

        return $this->response->send(['allow' => true]);


    }

    public function findTransaction() {

        if (array_key_exists('account', $this->request->data['params'])
            && array_key_exists('user_id', $this->request->data['params']['account'])
        ) {
            $transaction = Transaction::find()->where([
                'user_id' => $this->request->data['params']['account']['user_id'],
                'state' => array(Transaction::STATE_CREATED, Transaction::STATE_COMPLETED)
            ])->one();
        } elseif (array_key_exists('id', $this->request->data['params'])) {
            $transaction = Transaction::find()->where([
                'transaction_id' => $this->request->data['params']['id']
            ])->one();
        } else {
            return false;
        }

        return $transaction;

    }

    /**
     * @throws PaycomException
     */
    public function checkTransaction()
    {

        $transaction = $this->findTransaction();

        if (!$transaction instanceof Transaction) {
            $this->response->error(
                PaycomException::ERROR_TRANSACTION_NOT_FOUND,
                'Transaction not found.'
            );
        }

        return $this->response->send([
            'create_time' => $transaction->created_at * 1000,
            'perform_time' => $transaction->perform_at * 1000,
            'cancel_time' => $transaction->cancel_at * 1000,
            'transaction' => strval($transaction->id),
            'state' => $transaction->state,
            'reason' => $transaction->reason
        ]);

    }

    /**
     * @throws PaycomException
     */
    public function createTransaction()
    {

        $user = User::findOne($this->request->data['params']['account']['user_id']);

        if (!$user instanceof User) {
            $this->response->error(
                PaycomException::ERROR_INVALID_ACCOUNT,
                'Account not found.'
            );
            return;
	}

	if ($this->request->data['params']['amount'] < 1000 || $this->request->data['params']['amount'] > 100000000) {
                return $this->response->error(PaycomException::ERROR_INVALID_AMOUNT, 'Amount error');
        }

        if (array_key_exists('id', $this->request->data['params'])) {
            $transaction = Transaction::find()->where([
                'transaction_id' => $this->request->data['params']['id']
            ])->one();
        } elseif (array_key_exists('account', $this->request->data['params'])
            && array_key_exists('user_id', $this->request->data['params']['account'])
        ) {
            $transaction = Transaction::find()->where([
                'user_id' => $this->request->data['params']['account']['user_id'],
                'state' => array(Transaction::STATE_CREATED, Transaction::STATE_COMPLETED)
            ])->one();
        } else {
            throw new PaycomException(
                $this->request->id,
                'Parameter to find a transaction is not specified.',
                PaycomException::ERROR_INTERNAL_SYSTEM
            );
        }

        if ($transaction instanceof Transaction) {
            if ($transaction->state != Transaction::STATE_CREATED) {
                $this->response->error(
                    PaycomException::ERROR_COULD_NOT_PERFORM,
                    'Transaction found, but not active.'
                );
            } elseif ($transaction->isExpired()) {
                $transaction->cancel(Transaction::REASON_CANCELLED_BY_TIMEOUT);
                $this->response->error(
                    PaycomException::ERROR_COULD_NOT_PERFORM,
                    'Transaction is expired.'
                );
            } else {
                return $this->response->send([
                    'create_time' => $transaction->created_at * 1000,
                    'transaction' => strval($transaction->id),
                    'state' => $transaction->state,
                    'receivers' => null
                ]);
            }
        } else {
            if (intval($this->request->data['params']['time']) - time() * 1000 >= Transaction::TIMEOUT) {
                $this->response->error(
                    PaycomException::ERROR_INVALID_ACCOUNT,
                    PaycomException::message(
                        'С даты создания транзакции прошло ' . Transaction::TIMEOUT . 'мс',
                        'Tranzaksiya yaratilgan sanadan ' . Transaction::TIMEOUT . 'ms o`tdi',
                        'Since create time of the transaction passed' . Transaction::TIMEOUT . 'ms'
                    ),
                    'time'
                );
            }

            $transaction = new Transaction([
                'transaction_id' => $this->request->data['params']['id'],
                'time' => $this->request->data['params']['time'],
                'state' => Transaction::STATE_CREATED,
                'amount' => $this->request->data['params']['amount'],
                'user_id' => $this->request->data['params']['account']['user_id'],
            ]);
            $transaction->save();

            return $this->response->send([
                'create_time' => $transaction->created_at * 1000,
                'transaction' => strval($transaction->id),
                'state' => $transaction->state,
                'receivers' => null
            ]);
        }


    }

    /**
     * @throws PaycomException
     */
    public function performTransaction()
    {

        $transaction = $this->findTransaction();

        if (!$transaction instanceof Transaction) {
            $this->response->error(
                PaycomException::ERROR_TRANSACTION_NOT_FOUND,
                'Transaction not found.'
            );
        }

        switch ($transaction->state) {
            case Transaction::STATE_CREATED:
                if ($transaction->isExpired()) {
                    $transaction->cancel(Transaction::REASON_CANCELLED_BY_TIMEOUT);
                    $this->response->error(
                        PaycomException::ERROR_COULD_NOT_PERFORM,
                        'Transaction is expired.'
                    );
                } else {
                    $transaction->state = Transaction::STATE_COMPLETED;
                    $transaction->perform_at = time();
                    $transaction->save();

                    PaymentHistory::add(new PaymentHistoryDTO([
                        'user_id' => $transaction->user_id,
                        'payment_type' => PaymentHistory::PAYMENT_TYPE_PAYCOM,
                        'amount' => $transaction->amount / 100,
                        'transaction_id' => $transaction->id,
                        'description' => 'Paycom transaction'
                    ]));
                }

                return $this->response->send([
                    'transaction' => strval($transaction->id),
                    'perform_time' => $transaction->perform_at * 1000,
                    'state' => $transaction->state
                ]);

                break;
            case Transaction::STATE_COMPLETED:
                return $this->response->send([
                    'transaction' => strval($transaction->id),
                    'perform_time' => $transaction->perform_at * 1000,
                    'state' => $transaction->state
                ]);

                break;
            default:
                $this->response->error(
                    PaycomException::ERROR_COULD_NOT_PERFORM,
                    'Coult not perform this operation.'
                );
                break;
        }

    }

    /**
     * @throws PaycomException
     */
    public function cancelTransaction()
    {

        $transaction = $this->findTransaction();

        if (!$transaction instanceof Transaction) {
            $this->response->error(
                PaycomException::ERROR_TRANSACTION_NOT_FOUND,
                'Transaction not found.'
            );
        }

        switch ($transaction->state) {
            case Transaction::STATE_CANCELLED:
            case Transaction::STATE_CANCELLED_AFTER_COMPLETE:
                return $this->response->send([
                    'transaction' => strval($transaction->id),
                    'cancel_time' => $transaction->cancel_at * 1000,
                    'state' => $transaction->state
                ]);

                break;
            case Transaction::STATE_CREATED:
                $transaction->cancel(intval($this->request->data['params']['reason']));

                return $this->response->send([
                    'transaction' => strval($transaction->id),
                    'cancel_time' => $transaction->cancel_at * 1000,
                    'state' => $transaction->state
                ]);

                break;
            case Transaction::STATE_COMPLETED:
//                if (User::getBalanceByUserId($transaction->user_id) >= ($transaction->amount / 100)) {
                if (true) {
                    $transaction->cancel(intval($this->request->data['params']['reason']));

                    PaymentHistory::add(new PaymentHistoryDTO([
                        'user_id' => $transaction->user_id,
                        'payment_type' => PaymentHistory::PAYMENT_CANCELLED_TYPE_PAYCOM,
                        'amount' => -($transaction->amount / 100),
                        'transaction_id' => $transaction->id,
                        'description' => 'Transaction cancalled by Paycom'
                    ]));

                    return $this->response->send([
                        'transaction' => strval($transaction->id),
                        'cancel_time' => $transaction->cancel_at * 1000,
                        'state' => $transaction->state
                    ]);

                } else {
                    $this->response->error(
                        PaycomException::ERROR_COULD_NOT_CANCEL,
                        'Coult not cancel transaction. Order is delivered/Service is completed.'
                    );
                }

                break;
        }
    }


    public function changePassword()
    {

        if (!array_key_exists('password', $this->request->data['params'])
            || !trim($this->request->data['params']['password'])
        ) {
            $this->response->error(
                PaycomException::ERROR_INVALID_ACCOUNT,
                'New password not specified.',
                'password'
            );
        }

        if (file_get_contents(\Yii::getAlias('@common/../.paycom_key')) == $this->request->data['params']['password']) {
            $this->response->error(
                PaycomException::ERROR_INSUFFICIENT_PRIVILEGE,
                'Insufficient privilege. Incorrect new password.'
            );
        }

        if (!file_put_contents(\Yii::getAlias('@common/../.paycom_key'), $this->request->data['params']['password'])) {
            $this->response->error(
                PaycomException::ERROR_INTERNAL_SYSTEM,
                'Internal System Error.'
            );
        }

        return $this->response->send(['success' => true]);
    }

    private function getStatement()
    {
        $this->response->error(
            PaycomException::ERROR_INTERNAL_SYSTEM,
            'Internal System Error.'
        );
    }
}
