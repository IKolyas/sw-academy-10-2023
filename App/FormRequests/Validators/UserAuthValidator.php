<?php

namespace App\FormRequests\Validators;

class UserAuthValidator extends AbstractValidator
{
    public static function validateLogin(string $login): bool
    {
        return preg_match('/^[a-zA-Z0-9]{3,30}$/u', $login);
    }

    public static function validatePassword(string|null $login): bool
    {
        return preg_match('/^[a-zA-Z|^!-@~`}{_\[\]]{6,30}$/u', $login);
    }
}
