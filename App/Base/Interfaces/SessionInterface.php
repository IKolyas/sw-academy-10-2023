<?php

namespace App\Base\Interfaces;

interface SessionInterface
{
    public function get(string $key);

    public function set(string $key, $value);

    public function remove(string $key): void;

    public function clear(): void;

}
