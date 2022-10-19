<?php


namespace rakhmatov\payment\models\paynet;

class TransactionStatement {
    /**
     * @access public
     * @var integer
     */
    public $amount;
    /**
     * @access public
     * @var integer
     */
    public $providerTrnId;
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
