<?php

namespace app\Base\Config;

class Config
{
    private ?string $dbHost = null;
    private ?string $dbPort = null;
    private ?string $dbName = null;
    private ?string $dbUser = null;
    private ?string $dbPassword = null;
    static Config|null $instance = null;

    public function __construct()
    {
        $this->setConfig([
            'host' => 'localhost',
            'port' => '3306',
            'name' => 'UserName',
            'password' => '33333',
        ]);
    }

    public function setConfig(array $dbConfig): void
    {
        $this->dbHost = !empty($dbConfig['host']) ? $dbConfig['host'] : null;
        $this->dbPort = !empty($dbConfig['port']) ? $dbConfig['port'] : null;
        $this->dbName = !empty($dbConfig['name']) ? $dbConfig['name'] : null;
        $this->dbUser = !empty($dbConfig['user']) ? $dbConfig['user'] : null;
        $this->dbPassword = !empty($dbConfig['password']) ? $dbConfig['password'] : null;
    }

    function getDbData()
    {
        return [
            'host' => $this->dbHost,
            'port' => $this->dbPort,
            'name' => $this->dbName,
            'user' => $this->dbUser,
            'password' => $this->dbPassword,
        ];
    }

    public static function getInstance(): Config
    {
        if (is_null(static::$instance)) {
            static::$instance = new static();
        }

        return static::$instance;
    }
}

