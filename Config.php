<?php

class Config
{
    private $path_config_joomla_file = 'configuration.php';
    private $path_import_orders_dir = 'import-orders';
    private $login_db = '';
    private $password_db = '';
    private $name_bd = '';

    public function __construct($path_config_joomla_file='', $path_import_orders_dir='')
    {
        if (empty($path_config_joomla_file)){
            $this->setPathConfigFile($_SERVER['DOCUMENT_ROOT'].'/configuration.php');
        }else{
            $this->setPathConfigFile($path_config_joomla_file);
        }
        if (!empty($path_import_orders_dir)){
            $this->setPathImportOrdersDir($path_import_orders_dir);
        }
    }

    public function setPathConfigFile($path_file)
    {
        if ($path_file && !empty($path_file) && file_exists($path_file)){
            $this->path_config_joomla_file = $path_file;
        }
        $this->setLoginPasswordNameBb();
    }

    public function setPathImportOrdersDir($path_dir)
    {
        if ($path_dir && !empty($path_dir) && is_dir($path_dir)){
            $this->path_import_orders_dir = $path_dir;
        }
    }

    public function setLoginPasswordNameBb()
    {
        if (file_exists($this->path_config_joomla_file)) {
            require_once($this->path_config_joomla_file);
            if (class_exists('JConfig')){
                $config_joomla = new JConfig();
                $this->name_bd = $config_joomla->db;
                $this->login_db = $config_joomla->user;
                $this->password_db = $config_joomla->password;
            }
        }
    }

    /**
     * @return string
     */
    public function getLoginDb()
    {
        return $this->login_db;
    }

    /**
     * @return mixed
     */
    public function getPasswordDb()
    {
        return $this->password_db;
    }

    /**
     * @return mixed
     */
    public function getNameBd()
    {
        return $this->name_bd;
    }

    /**
     * @return string
     */
    public function getPathImportOrdersDir()
    {
        return $this->path_import_orders_dir;
    }



}