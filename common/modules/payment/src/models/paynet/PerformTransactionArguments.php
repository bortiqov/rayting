<?php


namespace rakhmatov\payment\models\paynet;

class PerformTransactionArguments extends GenericArguments {
    /**
     * @access public
     * @var integer
     */
    public $amount;
    /**
     * @access public
     * @var GenericParam[]
     */
    public $serviceId;
    /**
     * @access public
     * @var integer
     */
    public $transactionId;
    /**
     * @access public
     * @var dateTime
     */
    public $transactionTime;
}
