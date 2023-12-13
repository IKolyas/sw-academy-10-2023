<?php

namespace app\Base;
use app\Traits\SingleTon;

class Config
{

    use SingleTon;

    private ?array $dataDB = null;
    private ?array $dataUser = null;

    private ?array $config = null;
    private ?array $env = null;


    //static Config|null $instance = null;

    function __construct() {
        $this->config = require_once('../config/config.php');

        $this->setConfigBD($this->config['db']);
        $this->setConfigUser($this->config['user']);

        $this->env = parse_ini_file('../.env');
    }

    public function setConfigEnv(array $envConfig) 
    {
        $this->env = !empty($envConfig) ? $envConfig : null;

    } 
    public function getConfigEnv(): array|null
    {
        return $this->env;
    }


    public function setConfigBD(array $dbConfig) 
    {
        $this->dataDB = !empty($dbConfig) ? $dbConfig : null;

    }
    public function getConfigBD(): array|null
    {
        return $this->dataDB;
    }

    public function setConfigUser(array $usrConfig) 
    {   
        $this->dataUser = !empty($usrConfig) ? $usrConfig : null;

        /* if (!empty($dbConfig['name']) && !empty($dbDataBase['passwd'])) {
            $this->dataUser = [
                'name' => $usrConfig['name'],
                'passwd' =>$usrConfig['passwd'],
            ];
        } else {
            $this->dataUser = null;
        }; */
    }
    public function getConfigUser(): array|null
    {
        return $this->dataUser;
    }


    /* public static function getInstance(): Config
    {
        if (is_null(static::$instance)) {
            static::$instance = new static();
        }

        return static::$instance;
    } */
}
