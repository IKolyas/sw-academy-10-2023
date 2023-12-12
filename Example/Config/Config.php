<?php

namespace app\Example\Config;

class Config
{
    private ?string $dbHost = null;
    private ?string $dbPort = null;
    static Config|null $instance = null;

    public function __construct()
    {
        $this->setConfig([
            'host' => 'localhost',
            'port' => '3306',
        ]);
    }

    public function setConfig(array $dbConfig): void
    {
        $this->dbHost = !empty($dbConfig['host']) ? $dbConfig['host'] : null;
        $this->dbPort = !empty($dbConfig['port']) ? $dbConfig['port'] : null;
    }

    public function getDbData(): array
    {
        return [
            'host' => $this->dbHost,
            'port' => $this->dbPort,
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
