<?php

namespace App\FormRequests\Validators;

interface ValidatorInterface
{
    public static function isNumber(mixed $value): bool;
    public static function isString(mixed $value): bool;
    public static function isArray(mixed $value): bool;
    public static function isFile(mixed $value): bool;
}
