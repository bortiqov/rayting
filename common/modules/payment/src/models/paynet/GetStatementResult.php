<?php


namespace rakhmatov\payment\models\paynet;

class GetStatementResult extends GenericResult {
    /**
     * @access public
     * @var TransactionStatement[]
     */
    public $statements;
}
