<?php


namespace rakhmatov\payment\models\paynet;

class GetInformationArguments extends GenericArguments {
    /**
     * @access public
     * @var GenericParam[]
     */
    public $parameters;
    /**
     * @access public
     * @var integer
     */
    public $serviceId;
}
