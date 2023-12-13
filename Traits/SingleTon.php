<?php
namespace app\Traits;
trait SingleTon 
{
    static object|null $instance = null;

    public static function getInstance():object
    {
        if (is_null(static::$instance)) {
            static::$instance = new static();
        }

        return static::$instance;
    }
}