<?php
/**
 * @author Izzat <i.rakhmatov@list.ru>
 * @package payment
 */

namespace rakhmatov\payment\controllers;


use common\models\User;
use rakhmatov\payment\components\PaymentController;
use rakhmatov\payment\dto\PaymentHistoryDTO;
use rakhmatov\payment\exceptions\PaycomException;
use rakhmatov\payment\models\PaymentHistory;
use rakhmatov\payment\models\PaycomRequest;
use rakhmatov\payment\models\PaycomResponse;
use rakhmatov\payment\models\PaynetService;
use rakhmatov\payment\models\Transaction;
use yii\rest\Controller;
use rakhmatov\payment\models\paynet\CancelTransactionArguments;
use rakhmatov\payment\models\paynet\CancelTransactionResult;
use rakhmatov\payment\models\paynet\CheckTransactionArguments;
use rakhmatov\payment\models\paynet\CheckTransactionResult;
use rakhmatov\payment\models\paynet\GenericArguments;
use rakhmatov\payment\models\paynet\GenericParam;
use rakhmatov\payment\models\paynet\GenericResult;
use rakhmatov\payment\models\paynet\GetInformationArguments;
use rakhmatov\payment\models\paynet\GetInformationResult;
use rakhmatov\payment\models\paynet\GetStatementArguments;
use rakhmatov\payment\models\paynet\GetStatementResult;
use rakhmatov\payment\models\paynet\PerformTransactionArguments;
use rakhmatov\payment\models\paynet\PerformTransactionResult;
use rakhmatov\payment\models\paynet\TransactionStatement;

class PaynetController extends Controller
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
    public function __construct($id = null, $module = null, $config = [])
    {
//        $this->request = new PaynetRequest();
//        $this->response = new PaynetResponse($this->request);
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
        \Yii::$app->response->headers->add('Content-Type', 'text/xml');
//        if (
//            !\Yii::$app->request->getHeaders()->get('Authorization')
//            || !preg_match('/^s*Basic\s+(\S+)\s*$/i', \Yii::$app->request->getHeaders()->get('Authorization'), $matches)
//            || base64_decode($matches[1]) != \Yii::$app->params['paycom']['login'] . ":" . file_get_contents(\Yii::getAlias('@common/../.paycom_key'))
//        ) {
////            return $this->asJson(new PaycomException(
////                $this->request->id,
////                'Insufficient privilege to perform this method.',
////                PaycomException::ERROR_INSUFFICIENT_PRIVILEGE
////            ));
//        }
        header("Content-Type: text/xml; charset=utf-8");
        ini_set("soap.wsdl_cashe_enabled", "1");
//        $server = new \SoapServer(getenv('API_URL') . "payment/paynet/wsdl", array('soap_version' => SOAP_1_1, 'cache_wsdl' => WSDL_CACHE_NONE));
        $server = new \SoapServer(getenv("API_URL") . "payment/paynet/wsdl", array('soap_version' => SOAP_1_1, 'cache_wsdl' => WSDL_CACHE_NONE));
        $server->setObject(new PaynetService());
        $server->handle();

    }

    public function actionWsdl()
    {
        \Yii::$app->response->sendFile(\Yii::getAlias('@vendor/rakhmatov/yii2-payment/src/pservice/ProviderWebService.wsdl'));
    }

    public function actionXsd()
    {
        \Yii::$app->response->sendFile(\Yii::getAlias('@vendor/rakhmatov/yii2-payment/src/pservice/ProviderWebService.xsd'));
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

        $this->response->send(['allow' => true]);


    }

    public function findTransaction()
    {

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
    public function checkTransactiona()
    {

        $transaction = $this->findTransaction();

        if (!$transaction instanceof Transaction) {
            $this->response->error(
                PaycomException::ERROR_TRANSACTION_NOT_FOUND,
                'Transaction not found.'
            );
        }

        $this->response->send([
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
                $this->response->send([
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

            $this->response->send([
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
    public function performTransactiona()
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

                $this->response->send([
                    'transaction' => strval($transaction->id),
                    'perform_time' => $transaction->perform_at * 1000,
                    'state' => $transaction->state
                ]);

                break;
            case Transaction::STATE_COMPLETED:
                $this->response->send([
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
    public function cancelTransactiona()
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
                $this->response->send([
                    'transaction' => strval($transaction->id),
                    'cancel_time' => $transaction->cancel_at * 1000,
                    'state' => $transaction->state
                ]);

                break;
            case Transaction::STATE_CREATED:
                $transaction->cancel(intval($this->request->data['params']['reason']));

                $this->response->send([
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

                    $this->response->send([
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


    public function changePassworda()
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

        $this->response->send(['success' => true]);
    }

}
