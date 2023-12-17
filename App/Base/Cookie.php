<?php

namespace App\Base;

class Cookie
{
    public function getCookie(string $key): ?string
    {
        return $_COOKIE[$key] ?? null;
    }

    public function setCookie(string $key, $value): void
    {
        setcookie($key, $value, time() + env('COOKIE_TIME', 3600), '/');
    }

    public function removeCookie(string $key): void
    {
        setcookie($key, '', -1, '/');
    }

    public function getUserByCookie(string $cookie_key)
    {
//        TODO: реализовать получение пользователя из базы по куке
    }

    public function exists($key): bool
    {
        return isset($_COOKIE[$key]);
    }
}
