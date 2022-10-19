<?php
/**
 * @author Izzat <i.rakhmatov@list.ru>
 * @package payment
 */

namespace rakhmatov\payment\components;


use rakhmatov\payment\exceptions\PaycomException;
use rakhmatov\payment\models\Request;
use rakhmatov\payment\models\Response;
use yii\rest\Controller;

abstract class PaymentController extends Controller implements PaymentControllerInterface
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
        $this->request = new Request();
        $this->response = new Response($this->request);
        $this->id = $id;
        $this->module = $module;
        $this->config = $config;
    }

}