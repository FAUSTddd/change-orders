<?php

class Order
{
    //номер заказа
    private $number = '';
    //оплаченная сумма
    private $sum = 0.0;
    //new - новый; payments - оплаченный
    private $action = 'new';


    public function __construct()
    {

    }

    /**
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @param string $number
     */
    public function setNumber($number)
    {
        $this->number = (string)$number;
    }

    /**
     * @return float
     */
    public function getSum()
    {
        return $this->sum;
    }

    /**
     * @param float $sum
     */
    public function setSum($sum)
    {
        $this->sum = (string)$sum;
    }

    /**
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @param string $action
     */
    public function setAction($action)
    {
        $this->action = (string)$action;
    }




}