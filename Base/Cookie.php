<?php

namespace app\Base;

use Exception;

class Cookie
{

    private ?array $cookie = null;

    public function __construct()
    {
        $this->cookie = $_COOKIE ?? null;
    }

    public function getCookie()
    {
        return $this->cookie;
    }

    public function setCookie(string $key, string $value)
    {
        $config = Config::getInstance();
        $envConfig = $config->getEnvData();

        $cookieTime = $envConfig['COOKIE_TIME'];
        setcookie($key, $value, time() + $cookieTime);
    }
}