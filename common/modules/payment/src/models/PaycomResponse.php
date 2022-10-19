<?php
/**
 * @author Izzat <i.rakhmatov@list.ru>
 * @package payment
 */

namespace rakhmatov\payment\models;


use rakhmatov\payment\exceptions\PaycomException;

class PaycomResponse
{

    public $request;

    /**
     * PaycomResponse constructor.
     * @param PaycomRequest $request
     */
    public function __construct(PaycomRequest $request)
    {
        $this->request = $request;
    }

    /**
     * @param $result
     * @param null $error
     * @return \yii\web\Response
     */
    public function send($result, $error = null) {
        //\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
	    //return \Yii::$app->controller->asJson(
		return    array(
            'jsonrpc' => '2.0',
            'id' => $this->request->id,
            'result' => $result,
            'error' => $error
    		);
	// );
    }

    /**
     * @param $code
     * @param null $message
     * @param null $data
     * @throws PaycomException
     */
    public function error($code, $message = null, $data = null) {
        throw new PaycomException($this->request->id, $message, $code, $data);
    }
}
