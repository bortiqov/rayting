<?php
/**
 * @author Izzat <i.rakhmatov@list.ru>
 * @package payment
 */

namespace rakhmatov\payment;


class Module extends \yii\base\Module {

    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'rakhmatov\payment\controllers';

    /**
     * @inheritdoc
     */
    public function init() {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        parent::init();
    }

}
