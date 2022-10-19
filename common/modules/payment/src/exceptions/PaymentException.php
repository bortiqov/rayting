<?php
/**
 * @author Izzat <i.rakhmatov@list.ru>
 * @package payment
 */

namespace rakhmatov\payment\exceptions;

abstract class PaymentException extends \Exception
{

    public $request_id;

    public $error;

    public $data;

    public function __construct(int $request_id, string $message, int $code, array $data = null)
    {
        $this->request_id = $request_id;
        $this->message = $message;
        $this->code = $code;
        $this->data = $data;

        $this->error = array('code' => $this->code);

        if ($this->message) {
            $this->error['message'] = $this->message;
        }

        if ($this->data) {
            $this->error['data'] = $this->data;
        }
    }

    abstract public function getError();

    abstract public static function message($ru, $uz = '', $en = '');

}