<?php

namespace app\Base;

use app\Traits\Singleton;

class Config
{
    use Singleton;

    private ?array $config;

    public function __construct()
    {
        $configFilePath = '../config/config.php';

        if (file_exists($configFilePath))
        {
            $configData = include $configFilePath;
            if ($configData && is_array($configData))
            {
                $this->config = $configData;
            }
        }
    }

    public function getDbConfig(): ?array
    {
        return $this->config['db'] ?? null;
    }

    public function getEnvData(?string $key = null): ?array
    {
        if ($key) {
            return $this->config['env'][$key] ?? null;
        }

        $envFilePath = '../.env';

        if (file_exists($envFilePath))
        {
            $envData = parse_ini_file($envFilePath);
            if ($envData !== false && is_array($envData))
            {
                $this->config['env'] = $envData;
                return $this->config['env'];
            }
        }
        return null;

    }

    public function getConfig(): ?array
    {
        return $this->config;
    }

}

