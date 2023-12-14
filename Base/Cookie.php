<?php

namespace app\Base;

use app\Traits\Singleton;

class Cookie
{
    use Singleton;
    private ?array $cookie;

    public function __construct()
    {
        $this->cookie = $_COOKIE;
    }

    public function getCookie(string $key): ?string
    {
        return $this->cookie[$key] ?? null;
    }

    public function setCookieData(string $key, string $value): void
    {
        $expDate = Config::getInstance()->getEnvData('COOKIE_EXP');
        setcookie($key, $value, $expDate, '/');
    }
}