<?php

namespace App\Traits;

use Exception;

trait Singleton
{
    static ?self $instance = null;

    public static function getInstance(): ?self
    {
        if (is_null(static::$instance)) {
            static::$instance = new static();
        }
        return static::$instance;
    }

    public function __construct()
    {
    }

    public function __clone()
    {
        // TODO: Implement __clone() method.
    }

    public function __wakeup()
    {
        // TODO: Implement __wakeup() method.
    }

}