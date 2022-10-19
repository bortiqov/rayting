<?php


namespace rakhmatov\payment\models\paynet;

class GetStatementArguments extends GenericArguments {
    /**
     * @access public
     * @var dateTime
     */
    public $dateFrom;
    /**
     * @access public
     * @var dateTime
     */
    public $dateTo;
    /**
     * @access public
     * @var integer
     */
    public $serviceId;
}
