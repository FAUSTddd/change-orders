<?php
require_once('Order.php');
class Orders
{
    protected $config;
    private $orders = [];

    public function __construct($config)
    {
        if ($config && !empty($config)){
            $this->config = $config;
        }
    }


}