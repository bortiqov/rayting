<?php
/**
 * @author Izzat <i.rakhmatov@list.ru>
 * @package payment
 */

namespace rakhmatov\payment\exceptions;

class PaycomException extends PaymentException
{

    const ERROR_INVALID_AMOUNT = -31001;
    const ERROR_TRANSACTION_NOT_FOUND = -31003;
    const ERROR_COULD_NOT_CANCEL = -31007;
    const ERROR_COULD_NOT_PERFORM = -31008;
    const ERROR_INVALID_ACCOUNT = -31050;
    const ERROR_INTERNAL_SYSTEM = -32400;
    const ERROR_INSUFFICIENT_PRIVILEGE = -32504;
    const ERROR_INVALID_JSON_RPC_OBJECT = -32600;
    const ERROR_METHOD_NOT_FOUND = -32601;

    public $request_id;

    public $error;

    public $data;

    public function getError()
    {
        return array(
            'id' => $this->request_id,
            'result' => null,
            'error' => $this->error
        );
    }

    public static function message($ru, $uz = '', $en = '')
    {
        return array(
            'ru' => $ru,
            'uz' => $uz,
            'en' => $en
        );
    }

}