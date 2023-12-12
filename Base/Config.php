<?php

namespace app\Base;

use app\Traits\Singleton;

class Config
{
    use Singleton;

    private ?array $config;

    public function __construct()
    {
        $this->config = include('../config/config.php');
    }

    public function getDbConfig(): ?array
    {
        return $this->config['db'] ?? null;
    }

    // решено парсить именно тут, чтобы не засорять config файл
    public function getEnvConfig(): ?array
    {
        if (!isset($this->config['env']) && file_exists('../.env')) {
            $this->config['env'] = parse_ini_file('../.env');
        }
        return $this->config['env'] ?? null;
    }
}