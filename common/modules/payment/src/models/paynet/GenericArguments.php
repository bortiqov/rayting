<?php


namespace rakhmatov\payment\models\paynet;

class GenericArguments {
    /**
     * @access public
     * @var string
     */
    public $password;
    /**
     * @access public
     * @var string
     */
    public $username;

    public static function create(\StdClass $data)
    {
        $class = new static();
        foreach ($data as $key => $value) {
            if (property_exists($class, $key)) {
                if (in_array($key, ['dateFrom', 'dateTo', 'transactionTime']))
                    $class->{$key} = new \DateTime($value);
                else
                    $class->{$key} = $value;
            }
        }
        return $class;
    }
}
