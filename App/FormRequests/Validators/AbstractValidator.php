<?php

namespace App\FormRequests\Validators;

class AbstractValidator implements ValidatorInterface
{

    public static function isNumber(mixed $value): bool
    {
        return is_integer($value) || is_float($value);
    }

    public static function isString(mixed $value): bool
    {
        return is_string($value);
    }

    public static function isArray(mixed $value): bool
    {
        return is_array($value);
    }

    public static function isFile(mixed $value): bool
    {
//        TODO: add validation file
        return is_file($value);
    }
}
