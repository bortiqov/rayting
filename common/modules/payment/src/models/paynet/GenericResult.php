<?php


namespace rakhmatov\payment\models\paynet;

class GenericResult {
    /**
     * @access public
     * @var string
     */
    public $errorMsg;
    /**
     * @access public
     * @var integer
     */
    public $status;
    /**
     * @access public
     * @var dateTime
     */
    public $timeStamp;
}
