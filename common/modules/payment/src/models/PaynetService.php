<?php

namespace rakhmatov\payment\models;

use rakhmatov\payment\models\paynet\CancelTransactionResult;
use rakhmatov\payment\models\paynet\CheckTransactionResult;
use rakhmatov\payment\models\paynet\GenericParam;
use rakhmatov\payment\models\paynet\GetInformationResult;
use rakhmatov\payment\models\paynet\GetStatementResult;
use rakhmatov\payment\models\paynet\PerformTransactionArguments;
use rakhmatov\payment\models\paynet\PerformTransactionResult;
use rakhmatov\payment\models\paynet\TransactionStatement;
use rakhmatov\payment\models\Transaction;
use yii\db\Expression;

class PaynetService {

    public $exit = 5;
    public $msg = array(
        0 => "Ok",
        100 => "Услуга временно не поддерживается",
        102 => "Системная ошибка",
        103 => "Неизвестная ошибка",
        201 => "Транзакция уже существует",
        202 => "Транзакция уже отменана",
        302 => "Пользователь не существует",
        411 => "Не задан один или несколько обязательных параметров",
        412 => "Неверный логин",
        413 => "Неверная сумма",
        502 => "Клиент вне зоны обслуживания провайдера",
        601 => "Доступ запрещен"
    );

    private $username = "paynet";
//    private $password = "FgKHHFsytliO";
    private $password = "12345678";
//    private $allowedIps = array("213.230.106.115");
    private $allowedIps = array("192.168.31.197");

    private function checkIp() {
        return true;
    }

    private function extractAmount($string)
    {
        $arr = explode(",", $string);
        $arr = explode(" ", $arr[0]);
        return end($arr) * 100;
    }

    /**
     * Service Call: PerformTransaction
     * Parameter options:
     * @param mixed arguments PerformTransactionArguments
     * @return PerformTransactionResult
     */
    public function PerformTransaction($arguments)
    {
        // тут идет получение данных из SOAP
        $log5 = print_r(file_get_contents("php://input"), true);
        \Yii::error($log5);
        \Yii::error((json_encode($arguments)));
        $username = $arguments->username;
        $password = $arguments->password;
        $amount = $arguments->amount / 100;
        $parameters = $arguments->parameters;
        $serviceId = $arguments->serviceId;
        $transactionId = $arguments->transactionId;
        $transactionTime = $arguments->transactionTime;
        $account = $parameters->paramValue;
        //smtpSend("izzatraxmatov41@gmail.com", "PAYNET PT", $log5, "test");
        // Установим предпарамметры
        $isdn = 0; // номер нашей транзакции
        $st = 103; // стутус траназакции
        $balance = 0; // баланс плательщика
        $this->exit = 5;
        // теперь получим ип адрес запроса
        $ip = getenv('REMOTE_ADDR');
        // теперь проверим на ликвидность

        $ipflag = $this->checkIp();
        // ип адрес из списка запрещенных
        if ($ipflag != 5) {
            $st = 601;
            $this->exit = 2;
        } else {
            // *******************************************
            // теперь проверим логин на правильность
            if ($username != $this->username) {
                $st = 412;
                $this->exit = 2;
            };
            // теперь проверим пароль на правильность
            if ($password != $this->password) {
                $st = 601;
                $this->exit = 2;
            };
            // теперь проверим провайдера
            if ($serviceId != 1) {
                $st = 502;
                $this->exit = 2;
            };
            // теперь проверим есть ли все остальные параметры
            if ($amount == "" or $account == "" or $transactionId == "" or $transactionTime == "") {
                $st = 411;
                $this->exit = 2;
            };
            // here is coming business logic
            if ($this->exit != 2) {
                $user = \common\modules\user\models\User::findOne($account);
//                $res = mysql_query("select * from user where (id = '{$account}')");
                if (!$user instanceof \common\modules\user\models\User) {
                    $st = 302;
                    $this->exit = 2;
                }
            }
            if ($this->exit != 2) {
                $transaction = Transaction::find()->where(['transaction_id' => $transactionId])
//                    ->andWhere(['<>', 'state', Transaction::STATE_CANCELLED])
                    ->one();
//                $res = mysql_query("select * from transaction where externalId = {$transactionId} and paymer = 1 ");
                if ($transaction instanceof Transaction) {
                    $st = 201;
                    $this->exit = 2;
                }
            }
            if ($this->exit != 2) {
//                $exchange = mysql_query("select * from currency where currency_code = 'usd' order by id desc limit 1");
//                $exchange_row = mysql_fetch_assoc($exchange);
//                $calculated = round($amount / $exchange_row['value'], 2, PHP_ROUND_HALF_DOWN);
                $transaction = new Transaction();
                $transaction->user_id = $user->id;
                $transaction->created_at = time();
                $transaction->transaction_id = strval($transactionId);
                $transaction->amount = $amount;
                \Yii::error($transaction->save());
                \Yii::error(($transaction->getErrorSummary(true)));
//                mysql_query("insert into transaction (user, description, dateCreated, amount externalId, paymer) values
//				({$userRow['uid']}, 'paynet.uz #$transactionId payment of $amount', now(),
//				'$amount', '$transactionId', 1 )");
                $isdn = $transaction->id;
                $st = 0;

//                $res = mysql_query("SELECT sum(amount) FROM transaction WHERE user = {$userRow['id']} and (cancelled_at is null or cancelled_at=0) group by user");
                $balance = Transaction::find()->where(['user_id' => $user->id])->andWhere(['state' => Transaction::STATE_COMPLETED])->sum('amount');
//                $balanceRow = mysql_fetch_array($res);
//                $balance = $balanceRow[0];
            }
        };
        // тут мы выдаем ответ на запрос SOAP
        $result = new PerformTransactionResult();
        $result->providerTrnId = $isdn;
        $result->errorMsg = $this->msg[$st];
        $result->status = $st;
        $result->timeStamp = date("c");
        $param = new GenericParam();
        $param->paramKey = 'balance';
        $param->paramValue = intval($balance);
        $result->parameters = array($param);
        // тут отправка почты логов
        $log1 = print_r($arguments, true);
        $log2 = print_r($result, true);
        $log = '<pre>' . $log1 . '<br><br>' . $log2 . '</pre>';
        //smtpSend("izzatraxmatov41@gmail.com", "PAYNET PAY TRANSCTION", $log, "test");
        return $result;
    }

    /**
     * Service Call: CheckTransaction
     * Parameter options:
     * @param mixed arguments CheckTransactionArguments
     * @return CheckTransactionResult
     */
    public function CheckTransaction($arguments)
    {
        // тут идет получение данных из SOAP
        $password = $arguments->password;
        $username = $arguments->username;
        $serviceId = $arguments->serviceId;
        $transactionId = (int)$arguments->transactionId;
        // Установим предпарамметры
        $isdn = 0; // cвойства транзакции
        $st = 100; // стутус траназакции
        $this->exit = 5;
        // теперь получим ип адрес запроса
        $ip = getenv('REMOTE_ADDR');
        // теперь проверим на ликвидность
        $ipflag = $this->checkIp();
        // ип адрес из списка запрещенных
        if ($ipflag != 5) {
            $st = 601;
            $this->exit = 2;
        } else {
            // *******************************************
            // теперь проверим логин на правильность
            if ($username != $this->username) {
                $st = 412;
                $this->exit = 5;
            };
            // теперь проверим пароль на правильность
            if ($password != $this->password) {
                $st = 601;
                $this->exit = 2;
            };
            // теперь проверим провайдера
            if ($serviceId != 1) {
                $st = 502;
                $this->exit = 2;
            };
            // теперь проверим есть ли все остальные параметры
            if (!$transactionId) {
                $st = 411;
                $this->exit = 2;
            };

            $transactionState = 2;
            $transactionStateErrorStatus = 1;

            // here will coming business logic
            if ($this->exit != 2) {
//                $res = mysql_query("select * from transfer where externalId = {$transactionId} and paymer = 1 ");
                $transaction = Transaction::find()->where(['transaction_id' => $transactionId])->one();
                if (!$transaction instanceof Transaction) {
                    $st = 201;
                    $this->exit = 2;
                } else {
//                    $row = mysql_fetch_assoc($res);
                    $st = 0;
                    $isdn = $transaction->id;
                    $transactionState = 1;
                    $transactionStateErrorStatus = 0;
                    if ($transaction->state == Transaction::STATE_CANCELLED) {
                        $transactionState = 2;
                        $transactionStateErrorStatus = 1;
                    }
                }
            }
        }
        // тут мы выдаем ответ на запрос SOAP
        $result = new CheckTransactionResult();
        $result->errorMsg = $this->msg[$st];
        $result->status = $st;
        $result->timeStamp = date("c");;
        $result->providerTrnId = $isdn;
        $result->transactionState = $transactionState;
        $result->transactionStateErrorStatus = $transactionStateErrorStatus;
        $result->transactionStateErrorMsg = "Success";
        // тут отправка почты логов
        $log1 = print_r($arguments, true);
        $log2 = print_r($result, true);
//        $dataz = $transactionId . '-' . $rss;
//        $log = '<pre>' . $log1 . '<br><br>' . $dataz . '<br><br>' . $log2 . '</pre>';
        //smtpSend("v.sheyanov@mediabay.uz", "PAYNET CHECK", $log, "test");
        return $result;
    }

    /**
     * Service Call: CancelTransaction
     * Parameter options:
     * @param mixed arguments CancelTransactionArguments
     * @return CancelTransactionResult
     */
    public function CancelTransaction($arguments)
    {
        // тут идет получение данных из SOAP
        $password = $arguments->password;
        $username = $arguments->username;
        $serviceId = $arguments->serviceId;
        $transactionId = $arguments->transactionId;
        // Установим предпарамметры
        $isdn = 0; // cвойства транзакции
        $st = 100; // стутус траназакции
        $this->exit = 5;
        // теперь получим ип адрес запроса
        $ip = getenv('REMOTE_ADDR');
        // теперь проверим на ликвидность
        $ipflag = $this->checkIp();
        // ип адрес из списка запрещенных
        if ($ipflag != 5) {
            $st = 601;
            $this->exit = 2;
        } else {
            // *******************************************
            // теперь проверим логин на правильность
            if ($username != $this->username) {
                $st = 412;
                $this->exit = 5;
            };
            // теперь проверим пароль на правильность
            if ($password != $this->password) {
                $st = 601;
                $this->exit = 2;
            };
            // теперь проверим провайдера
            if ($serviceId != 1) {
                $st = 502;
                $this->exit = 2;
            };
            // теперь проверим есть ли все остальные параметры
            if ($transactionId == "") {
                $st = 411;
                $this->exit = 2;
            };

            // here will coming business logic
            if ($this->exit != 2) {
                $transaction = Transaction::find()->where(['transaction_id' => $transactionId])
                    ->andWhere(['IS', 'state', new Expression("NULL")])
                    ->one();
//                $res = mysql_query("select * from transfer where externalId = {$transactionId} and paymer = 1 ");
                if (!$transaction instanceof Transaction) {
                    $st = 202;
                    $this->exit = 2;
                } else {
                    $isdn = $transaction->id;
                    $transaction->state = Transaction::STATE_CANCELLED;
                    $transaction->cancel_at = time();

                    if ($transaction->save()) {
                        $st = 0;
                    } else {
                        $st = 601;
                    }
                }
            }
        }
        // тут мы выдаем ответ на запрос SOAP
        $result = new CancelTransactionResult();
        $result->errorMsg = $this->msg[$st];
        $result->status = $st;
        $result->timeStamp = date("c");
        $result->transactionState = 2;
        // тут отправка почты логов
        $log1 = print_r($arguments, true);
        $log2 = print_r($result, true);
//        $dataz = $transactionId . '-' . $rss;
//        $log = '<pre>' . $log1 . '<br><br>' . $dataz . '<br><br>' . $log2 . '</pre>';
        //smtpSend("v.sheyanov@mediabay.uz", "PAYNET CANCEL TRANSCTION", $log, "test");
        return $result;
    }

    /**
     * Service Call: GetStatement
     * Parameter options:
     * @param mixed arguments GetStatementArguments
     * @return GetStatementResult
     */
    public function GetStatement($arguments)
    {
        // тут идет получение данных из SOAP
        $dateFrom = $arguments->dateFrom;
        $dateTo = $arguments->dateTo;
        $password = $arguments->password;
        $serviceId = $arguments->serviceId;
        $username = $arguments->username;
        // Установим предпарамметры
        $st = 103; // стутус траназакции
        $this->exit = 5;
        // теперь получим ип адрес запроса
        $ip = getenv('REMOTE_ADDR');
        // теперь проверим на ликвидность
        $ipflag = $this->checkIp();
        // ип адрес из списка запрещенных
        if ($ipflag != 5) {
            $st = 601;
            $this->exit = 2;
        } else {
            // *******************************************
            // теперь проверим логин на правильность
            if ($username != $this->username) {
                $st = 412;
                $this->exit = 2;
            };
            // теперь проверим пароль на правильность
            if ($password != $this->password) {
                $st = 601;
                $this->exit = 2;
            };
            // теперь проверим провайдера
            if ($serviceId != 1) {
                $st = 502;
                $this->exit = 2;
            };
            // теперь проверим есть ли все остальные параметры
            if ($dateFrom == "" or $dateTo == "") {
                $st = 411;
                $this->exit = 2;
            };

            $statements = [];

            // here will coming business logic
            if ($this->exit != 2) {
                $st = 0;
		$transaction = Transaction::find()->where(['>=', 'created_at', strtotime($dateFrom)])->andWhere(['<=', 'created_at', strtotime($dateTo)])
			->andWhere(['<>', 'state', Transaction::STATE_CANCELLED])
			->one();
//                $res = mysql_query($q = "select *, unix_timestamp(dateCreated) as ut from transfer where paymer = 1 and (canceled is null or canceled = false ) and dateCreated>='$dateFrom' and dateCreated<='$dateTo' ");
                //smtpSend("izzatraxmatov41@gmail.com", "PAYNET INFO", mysql_error().$q, null);
                if ($transaction instanceof Transaction) {
                    $statement = new TransactionStatement();
                    $statement->amount = $transaction->amount * 100;
                    $statement->providerTrnId = $transaction->id;
                    $statement->transactionId = $transaction->transaction_id;
                    $statement->transactionTime = date('c', $transaction->created_at);
                    $statements[] = $statement;
                }
            }
        }
        // тут мы выдаем ответ на запрос SOAP
        $result = new GetStatementResult();
        $result->errorMsg = $this->msg[$st];
        $result->status = $st;
        $result->timeStamp = date("c");
        $result->statements = $statements;
        // тут отправка почты логов
        $log1 = print_r($arguments, true);
        $log2 = print_r($result, true);
//        $dataz = $transactionId . '-' . $rss;
//        $log = '<pre>' . $log1 . '<br><br>' . $dataz . '<br><br>' . $log2 . '</pre>';
        //smtpSend("izzatraxmatov41@gmail.com", "PAYNET log", $log, "test");
        return $result;
    }

    /**
     * Service Call: GetInformation
     * Parameter options:
     * @param mixed arguments GetInformationArguments
     * @return GetInformationResult
     */
    public function GetInformation($arguments)
    {
        // тут идет получение данных из SOAP
        $username = $arguments->username;
        $password = $arguments->password;
        $parameters = $arguments->parameters;
        $serviceId = $arguments->serviceId;
        $account = $parameters->paramValue;
        $name = $parameters->paramKey;
        // Установим предпарамметры
        $st = 103; // стутус траназакции
        $balance = 0; // баланс плательщика
        $this->exit = 5;
        // теперь получим ип адрес запроса
        $ip = getenv('REMOTE_ADDR');
	$parameter = new GenericParam(); 
	// теперь проверим на ликвидность
        $ipflag = $this->checkIp();
        // ип адрес из списка запрещенных
        if ($ipflag != 5) {
            $st = 601;
            $this->exit = 2;
        } else {
            // *******************************************
            // теперь проверим логин на правильность
            if ($username != $this->username) {
                $st = 412;
                $this->exit = 2;
            };
            // теперь проверим пароль на правильность
            if ($password != $this->password) {
                $st = 601;
                $this->exit = 2;
            };
            // теперь проверим провайдера
            if ($serviceId != 1) {
                $st = 502;
                $this->exit = 2;
            };
            // теперь проверим есть ли все остальные параметры
            if ($account == "") {
                $st = 411;
                $this->exit = 2;
            };
            // проверим запрос имя
            if ($name != "account") {
                $st = 100;
                $this->exit = 2;
                $nz = "balance";
            };
            if ($name == "account") {
                $nz = "balance";
            };

            // here will coming business logic
            if ($this->exit != 2) {
                $user = \common\modules\user\models\User::findOne($account);
//                $res = mysql_query($q = "select * from user where (uid = '{$account}') and validated = 1 and enabled = 1");
                //smtpSend("izzatraxmatov41@gmail.com", "PAYNET INFO", mysql_error().$q, null);
                if (!$user instanceof \common\modules\user\models\User) {
                    $st = 302;
                    $this->exit = 2;
                } else {
                    $st = 0;
                    $this->exit = 5;
                }
            }

            if ($this->exit != 2) {
//                $res = mysql_query("SELECT sum(amount) FROM transfer WHERE user = {$userRow['uid']} and (canceled is null or canceled=0) group by user");
                $transactionAmount = Transaction::find()->where(['user_id' => $user->id])->andWhere(['<>', 'state', Transaction::STATE_CANCELLED])->sum('amount');
//                $balanceRow = mysql_fetch_array($res);
//                $balance = $balanceRow[0];

                $parameter = new GenericParam();
                $parameter->paramKey = $nz;
                $parameter->paramValue = intval($transactionAmount);
            }
        }
        // тут мы выдаем ответ на запрос SOAP
        $result = new GetInformationResult();
        $result->errorMsg = $this->msg[$st];
        $result->status = $st;
        $result->timeStamp = date("c");
	$result->parameters = array($parameter);
        // тут отправка почты логов
        $log1 = print_r($arguments, true);
        $log2 = print_r($result, true);
//        $dataz = $transactionId . '-' . $rss;
//        $log = '<pre>' . $log1 . '<br><br>' . $dataz . '<br><br>' . $log2 . '</pre>';
        //smtpSend("izzatraxmatov41@gmail.com", "PAYNET INFO", $log, "test");
        return $result;
    }
}
