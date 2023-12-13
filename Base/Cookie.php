<?php

namespace app\Base;

use app\Traits\Singleton;

class Cookie
{
    use Singleton;

    private ?array $cookies;

    public function __construct()
    {
        $this->cookies = $_COOKIE;
    }

    public function get(string $key): ?string
    {
        return $this->cookies[$key] ?? null;
    }

    public function write(string $key, string $value): void
    {
        $expDate = time() + Config::getInstance()->getEnvData()['COOKIE_EXP_DATE'];
        setcookie($key, $value, $expDate, '/');
    }
}