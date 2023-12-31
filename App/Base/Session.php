<?php

namespace App\Base;

use App\Base\Interfaces\SessionInterface;

class Session implements SessionInterface
{

    public function __construct()
    {
        session_start();
    }

    public function get(string $key): mixed
    {
        return $_SESSION[$key] ?? null;
    }

    public function addToArray(string $key, mixed $value): void
    {
        $data = $this->get($key) ?? [];
        $newData = array_merge($data, $value);
        $_SESSION[$key] = $newData;
    }

    public function set(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }

    public function remove(string $key): void
    {
        unset($_SESSION[$key]);
    }

    public function clear(): void
    {
        session_unset();
    }

    public function destroy(): void
    {
        session_destroy();
    }
}
