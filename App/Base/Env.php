<?php

namespace App\Base;

use App\Traits\Singleton;
use InvalidArgumentException;
use RuntimeException;

class Env
{
    use Singleton;

    /**
     * Путь к файлу env.
     * @var string
     */
    protected string $path;
    protected array $data = [];


    public function __construct()
    {
        $path = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . '../.env';

        if (!file_exists($path)) {
            throw new InvalidArgumentException(sprintf('Файл %s не найден', $path));
        }

        $this->path = $path;
        $this->data = $this->load();
    }

    protected function load(): array
    {
        if (!is_readable($this->path)) {
            throw new RuntimeException(sprintf('Не удалось прочитать файл %s', $this->path));
        }

        $lines = file($this->path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        $envData = [];

        foreach ($lines as $line) {

            if (str_starts_with(trim($line), '#')) {
                continue;
            }

            [$name, $value] = explode('=', $line, 2);

            $name = trim($name);
            $value = trim($value);

            if (!strlen($name) || !strlen($value)) {
                continue;
            }

            $envData[$name] = $value;
        }

        return $envData;
    }

    public function get(string $key): ?string
    {
        return $this->data[$key] ?? null;
    }
}