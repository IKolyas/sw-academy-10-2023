<?php

namespace App\Base;

interface SessionInterface
{
    public function get(string $key);

    public function set(string $key, $value): self;

    public function remove(string $key): void;

    public function clear(): void;

    public function has(string $key): bool;
}