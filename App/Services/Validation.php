<?php

namespace App\Services;
use App\Traits\Singleton;

class Validation
{
    use Singleton;

    public static function isEmail(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public static function isName(string $name): bool
    {
        // only letters and one or zero "-" in one-two words
        return preg_match('/^([a-zA-Zа-яА-Я]+(-?){0,1}\s?){1,2}$/u', $name);
    }

    public static function validateLogin(string $login): bool
    {
        return preg_match('/^[a-zA-Z0-9]{3,30}$/u', $login);
    }

    public static function validatePassword(string $login): bool
    {
        return preg_match('/^[a-zA-Z|^!-@~`}{_\[\]]{6,30}$/u', $login);
    }

    public static function isDate(string $date): bool
    {
        return preg_match('/^\d{4}-\d{2}-\d{2}$/', $date);
    }
}