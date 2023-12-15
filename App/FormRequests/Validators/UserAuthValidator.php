<?php

namespace App\FormRequests\Validators;

class UserAuthValidator extends AbstractValidator
{
    public static function validateLogin(?string $login): bool
    {
        return $login && preg_match('/^[a-zA-Z0-9]{3,30}$/u', $login);
    }

    public static function validatePassword(?string $password): bool
    {
        return $password && preg_match('/^[a-zA-Z|^!-@~`}{_\[\]]{6,30}$/u', $password);
    }

    public static function validateEmail(string $email): bool
    {
        return $email && filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public static function validateName(string $name): bool
    {
        // only letters and one or zero "-" in one-two words
        return $name && preg_match('/^([a-zA-Zа-яА-Я]+(-?){0,1}\s?){1,2}$/u', $name);
    }

    public static function validateField(string $field, ?string $value): bool
    {
        return match ($field) {
            'login' => self::validateLogin($value),
            'password', 'confirm_password' => self::validatePassword($value),
            'email' => self::validateEmail($value),
            'first_name', 'last_name' => self::validateName($value),
            default => false,
        };
    }
}
