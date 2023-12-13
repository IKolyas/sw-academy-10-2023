<?php
namespace app\Traits;
trait SingleTon 
{
    private static ?self $instance = null;

    public static function getInstance(): static
    {
        if (is_null(static::$instance)) {
            static::$instance = new static();
        }

        return static::$instance;
    }
}