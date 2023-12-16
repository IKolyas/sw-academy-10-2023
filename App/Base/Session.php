<?php

namespace App\Base;

class Session implements SessionInterface
{

    public function __construct()
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            return;
        }
        session_start();
    }

    public function get(string $key): mixed
    {
        return $_SESSION[$key] ?? null;
    }

    public function add(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
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
