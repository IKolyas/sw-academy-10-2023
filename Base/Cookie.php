<?php

namespace app\Base;

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
        if (!empty($_COOKIE[$key]) && $_COOKIE[$key] == $value) {
            echo "<sapn style='color:red'>Куки с таким именем и значением существует!</span>";
        } else {
            $config = Config::getInstance();
            $envConfig = $config->getEnvData();
    
            $cookieTime = $envConfig['COOKIE_TIME'];
            setcookie($key, $value, time() + $cookieTime);  // срок действия - 1 час (3600 секунд)
        }
    }
}