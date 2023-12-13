<?php

namespace app\Traits;

trait Singleton
{
    private static ?self $instance;

    public static function getInstance(): static
    {
        if (!isset(static::$instance)) {
            static::$instance = new static();
        }
        return static::$instance;
    }
}