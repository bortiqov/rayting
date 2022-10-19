<?php
/**
 * @author Izzat <i.rakhmatov@list.ru>
 * @package payment
 */

namespace rakhmatov\payment\models;


use rakhmatov\payment\exceptions\ClickException;
use yii\base\Exception;

class ClickRequest
{

    public $data;

    public $id;

    public $method;

    public $params;

    public $amount;


    /**
     * ClickRequest constructor.
     * @throws ClickException
     */
    public function __construct()
    {
//        $request_body = file_get_contents('php://input');
        $this->data['params'] = \Yii::$app->request->post();

//        if (!$this->data) {
//            throw new ClickException(
//                1,
//                'Invalid JSON-RPC object',
//                ClickException::ERROR_INVALID_JSON_RPC_OBJECT
//            );
//        }

//        $this->id = array_key_exists('id', $this->data) ? intval($this->data['id']) : null;
//        $this->method = array_key_exists('method', $this->data) ? trim($this->data['id']) : null;
//        $this->method = array_key_exists('params', $this->data) ? ($this->data['params']) : null;
//        $this->method = array_key_exists('amount', $this->data['params']) ? doubleval($this->data['params']['amount']) : null;

//        $this->params['request_id'] = $this->id;
    }

}