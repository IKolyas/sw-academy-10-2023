<?php

namespace app\Base;
use app\Traits\SingleTon;

class Config
{

    use SingleTon;

    private ?array $config = null;
    private ?array $env = null;

    function __construct() {
        $this->config = require_once('../config/config.php');

        if (parse_ini_file('../.env')) {
            $this->env['env'] = parse_ini_file('../.env');
        } else {
            echo "<p style='color:red'>env-файл не найден!</p>";
        }
       
    }

    public function setConfigEnv(array $envConfig): void
    {
        $this->env = !empty($envConfig) ? $envConfig : null;

    } 
    public function getConfigEnv(): ?array
    {
        return $this->env;
    }


    public function setConfig(string $configName, array $config): void
    {
        $nameConfig = $this->config[$configName];

        if (!empty($nameConfig)) {
            foreach ($config as $key=>$val) {
                $this->config[$configName][$key] = $val;
            }
        } else {
            $this->config[$configName] = $config;
        }

    }

    public function getConfigAll(): ?array
    {
        return $this->config;
    }

    public function getConfigOne(string $nameGroup): ?array
    {
        return $this->config[$nameGroup];
    }

}
