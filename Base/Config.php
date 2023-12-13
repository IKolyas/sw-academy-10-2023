<?php

namespace app\Base;

use app\Traits\Singleton;
use Exception;

class Config
{
    use Singleton;

    private ?array $config;
    private ?array $envData;

    public function __construct()
    {
        $this->loadData();
    }

    /**
     * @throws Exception
     */
    private function loadData(): void
    {
        $configFile = '../config/config.php';
        $envFile = '../.env';

        $config = require $configFile;
        $envConfig = parse_ini_file($envFile);

        if (!empty($envConfig) && is_array($envConfig)) {
            $this->envData = $envConfig;
        }

        if (!empty($config) && is_array($config)) {
            $this->config = $config;
        }
    }

    public function setConfig(array $config): void
    {
        if (empty($config)) {
            return;
        }

        $this->config = $config;
    }

    public function getConfig(): ?array
    {
        return $this->config;
    }

    public function getEnvData(): ?array
    {
        return $this->envData ?? null;
    }
}