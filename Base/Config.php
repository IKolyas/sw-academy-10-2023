<?php

namespace app\Base;

use app\Traits\Singleton;
class Config
{
    use Singleton;
    private $config;

    public function __construct()
    {
        $this->config = require '../config/config.php';
    }

    public function getDbConfig(): ?array
    {
        return $this->config['db'] ?? null;
    }

    public function getEnvConfig()
    {
        $this->config['env'] = parse_ini_file('../.env');

        return $this->config['env'] ?? null;
    }

    public function getConfig() {
        return $this->config;
    }

}

