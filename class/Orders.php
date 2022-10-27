<?php
require_once('Order.php');
require_once('Config.php');

class Orders
{
    private $config;
    private $orders = [];

    public function __construct()
    {
        $this->config = new Config();
        $this->getOrdersFromXml();
        $this->saveOrdersInBD();
    }

    /**
     * @return array
     */
    public function getOrders()
    {
        return $this->orders;
    }

    /**
     * @param array $orders
     */
    public function addOrder($order)
    {
        $this->orders[] = $order;
    }

    public function getOrdersFromXml()
    {
        $dir_orders = $this->config->getPathImportOrdersDir();
        $open_dir = opendir($dir_orders);
        while (false !== ($file = readdir($open_dir))) {
            if ($file != '.' && $file != '..' && !is_dir($dir_orders . '/' . $file) && $file[0] != '.') {
                $orders_xml = simplexml_load_file($dir_orders . '/' . $file);

                foreach ($orders_xml->ordersPayments->order as $order_xml) {
                    $Order = new Order();
                    $Order->setNumber($order_xml['Number']);
                    $Order->setSum($order_xml['Sum']);
                    $Order->setAction('payments');
                    $this->addOrder($Order);
                }
                foreach ($orders_xml->ordersNew->order as $order_xml) {

                    $Order = new Order();
                    $Order->setNumber($order_xml['Number']);
                    $Order->setSum($order_xml['Sum']);
                    $Order->setAction('new');

                    $this->addOrder($Order);
                }
            }
        }
    }

    public function saveOrdersInBD()
    {
        $login_bd = $this->config->getLoginDb();
        $password_bd = $this->config->getPasswordDb();
        $name_bd = $this->config->getNameBd();
        $conn = new mysqli("localhost", $login_bd, $password_bd, $name_bd);

        if ($conn->connect_error) {
            die("Ошибка: " . $conn->connect_error);
        }

        if (!empty($this->orders)) {
            foreach ($this->getOrders() as $order) {

                $order_name = $order->getNumber();
                $order_sum = $order->getSum();
                $order_name = '56112';
                $sql_test = "SELECT *  FROM auvf_yandexclient WHERE `name` = '$order_name'";
                $row = $conn->query($sql_test)->num_rows;
                $sql = '';
                if ($order->getAction() === 'payments' && $row >= 1) {
                    $sql = "DELETE FROM auvf_yandexclient WHERE `name`= '$order_name'";

                } elseif ($order->getAction() === 'new' && $row == 0) {
                    $sql = "INSERT INTO `auvf_yandexclient`(`name`, `price`, `status`) VALUES ($order_name, $order_sum, '0')";
                }

                if (!empty($sql) && $conn->query($sql)) {
                    echo "Данные успешно добавлены";
                } else {
                    echo "Ошибка: " . $conn->error;
                }

            }
        }

        $conn->close();
    }
}