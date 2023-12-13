<?php

namespace app\Base;

use app\Traits\Singleton;
use Exception;

class Config
{
    use Singleton;

    private ?array $config;

    public function __construct()
    {
        $configFile = '../config/config.php';
        $envFile = '../.env';
        try {
            $this->loadData($configFile, 'include');
            $this->loadData($envFile, 'parse', 'env');
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * @param string $path Путь до файла, который нужно загрузить
     * @param string $method Метод парсинга
     * @param string|null $key Ключ конфига
     * @throws Exception
     */
    private function loadData(
        string $path,
        string $method,
        ?string $key = null
    ): void
    {
        if (!file_exists($path)) {
            throw new Exception($key . ' file not found');
        }

        $data = [];

        if ($method === 'parse') {
            $data = parse_ini_file($path, true);
        } else {
            $data = include($path);
        }

        if (!is_array($data) || empty($data)) {
            throw new Exception($key . ' file is empty');
        }

        if ($key) {
            $this->config[$key] = $data;
            return;
        }

        $this->config = $data;
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

    public function getDbConfig(): ?array
    {
        return $this->config['db'] ?? null;
    }

    // решено парсить именно тут, чтобы не засорять config файл
    public function getEnvConfig(): ?array
    {
        return $this->config['env'] ?? null;
    }
}