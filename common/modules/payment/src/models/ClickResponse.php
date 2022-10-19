<?php
/**
 * @author Izzat <i.rakhmatov@list.ru>
 * @package payment
 */

namespace rakhmatov\payment\models;


use rakhmatov\payment\exceptions\ClickException;

class ClickResponse
{

    public $request;

    /**
     * ClickResponse constructor.
     * @param ClickRequest $request
     */
    public function __construct(ClickRequest $request)
    {
        $this->request = $request;
    }

    /**
     * @param $result
     * @param null $error
     * @return \yii\web\Response
     */
    public function send($result, $error = null) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return \Yii::$app->controller->asJson($result);
    }

    /**
     * @param $code
     * @param null $message
     * @param null $data
     * @throws ClickException
     */
    public function error($data = null) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return \Yii::$app->controller->asJson($data);
    }
}