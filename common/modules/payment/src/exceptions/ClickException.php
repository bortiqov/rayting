<?php
/**
 * @author Izzat <i.rakhmatov@list.ru>
 * @package payment
 */

namespace rakhmatov\payment\exceptions;

class ClickException extends PaymentException
{

    const SUCCESS = 0;
    const ERROR_SIGN_CHECH_FAILED = -1;
    const ERROR_INCORRECT_AMOUNT = -2;
    const ERROR_ACTION_NOT_FOUND = -3;
    const ERROR_ALREADY_PAID = -4;
    const ERROR_USER_NOT_FOUND = -5;
    const ERROR_TRANSACTION_NOT_FOUND = -6;
    const ERROR_FAILED_TO_UPDATE_USER = -7;
    const ERROR_ERROR_FROM_CLICK = -32600;
    const ERROR_TRANSACTION_CANCELLED = -32601;
    const ERROR_UNKNOWN = '-n';

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