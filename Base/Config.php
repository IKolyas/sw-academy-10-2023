<?php

namespace app\Base;

class Config
{
    /* private ?string $dbHost = null;
    private ?string $dbPort = null;
    private ?string $dbDataBase = null;
    private ?string $usrName = null;
    private ?string $usrPass = null; */

    private ?array $dataDB = null;
    private ?array $dataUser = null;

    private ?array $config = null;

    static Config|null $instance = null;

    function __construct() {
        $this->config = require_once('../config/config.php');

        $this->setConfigBD($this->config['db']);
        $this->setConfigUser($this->config['user']);
    }

    public function setConfigBD(array $dbConfig) 
    {
        //$this->dataDB = $dbConfig ?? $dbConfig ;
        /* $this->dataDB = [
            'host' => !empty($dbConfig['host']) ? $dbConfig['host'] : null,
            'database' => !empty($dbDataBase['database']) ? $dbDataBase['database'] : null,
            'port' => !empty($dbConfig['port']) ? $dbConfig['port'] : null,
        ]; */

        /* $this->dbHost = !empty($dbConfig['host']) ? $dbConfig['host'] : null;
        $this->dbDataBase = !empty($dbDataBase['database']) ? $dbDataBase['database'] : null;
        $this->dbPort = !empty($dbConfig['port']) ? $dbConfig['port'] : null; */
    }

    public function setConfigUser(array $usrConfig) 
    {
        $this->dataUser = [
            'name' => !empty($usrConfig['name']) ? $usrConfig['name'] : null,
            'passwd' => !empty($usrConfig['passwd']) ? $usrConfig['passwd'] : null,
        ];
    }

    public function getConfigBD(): array
    {
        return $this->dataDB;
        /* return [
            'host' => $this->dbHost,
            'port' => $this->dbPort,
            'database' => $this->dbDataBase,
        ]; */
    }
    
    public function getConfigUser(): array
    {
        /* return [
            'name' => $this->usrName,
            'passwd' => $this->usrPass,
        ]; */
        return $this->dataUser;
    }


    public static function getInstance(): Config
    {
        if (is_null(static::$instance)) {
            static::$instance = new static();
        }

        return static::$instance;
    }
}
