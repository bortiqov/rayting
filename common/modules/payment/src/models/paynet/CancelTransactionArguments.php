<?php


namespace rakhmatov\payment\models\paynet;

class CancelTransactionArguments extends GenericArguments {
    /**
     * @access public
     * @var integer
     */
    public $serviceId;
    /**
     * @access public
     * @var integer
     */
    public $transactionId;
}
