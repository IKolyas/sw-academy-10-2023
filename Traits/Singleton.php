<?php

namespace app\Traits;

trait Singleton
{
    private static $instance;

    public static function getInstance(): static
    {
        if (static::$instance === null) {
            static::$instance = new static();
        }

        return static::$instance;
    }


}