<?php

namespace app\Traits;
trait Singleton
{
    private static ?array $instance;

    protected function  __construct() { }
    final protected function  __clone() { }

    final public static function getInstance()
    {
        $calledClass = get_called_class();
        if (!isset(static::$instance[ $calledClass ])) {
            static::$instance[$calledClass] = new $calledClass();
        }
        return static::$instance[$calledClass];
    }

}