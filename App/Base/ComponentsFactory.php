<?php

namespace App\Base;

use Exception;
use ReflectionClass;
use ReflectionException;

class ComponentsFactory
{
    /**
     * Создаёт объект ReflectionClass
     * @throws ReflectionException
     * @throws Exception
     * https://www.php.net/manual/ru/book.reflection.php
     */

    public function createComponent($name, $params): ?object
    {
        $class = $params['class'];

        if (class_exists($class)) {
            unset($params['class']);
            $reflection = new ReflectionClass($class);
            return $reflection->newInstanceArgs(array_values($params));
        }

        throw new Exception("Не найден класс компонента <$name>");
    }
}