<?php

namespace App\FormRequests;

use App\Base\Request;
use App\FormRequests\Validators\UserAuthValidator;
use Exception;

class UserAuthRequest extends Request
{
    protected array $errors = [];


    /**
     * @throws Exception
     */
    public function validated(): array
    {

        $fields = [
            'login' => $this->getParam('login') ?? null,
            'password' => $this->getParam('password') ?? null,
        ];

        if (!$fields['login'] || !$fields['password']) {
            $this->errors[] = 'Login and password are required';
            throw new \Exception(implode(', ', $this->errors));
        }

        if (!UserAuthValidator::isString($fields['login'])) {
            $this->errors[] = 'Login is not valid';
            throw new \Exception(implode(', ', $this->errors));
        }

        if (!UserAuthValidator::isString($fields['password'])) {
            $this->errors[] = 'Login is not valid';
            throw new \Exception(implode(', ', $this->errors));
        }

        if (!UserAuthValidator::validatePassword($fields['password'])) {
            $this->errors[] = 'Password is not valid';
            throw new \Exception(implode(', ', $this->errors));
        }

        if (!UserAuthValidator::validateLogin($fields['login'])) {
            $this->errors[] = 'Login is not valid';
            throw new \Exception(implode(', ', $this->errors));
        }

        return $fields;
    }

    public function errors(): array
    {
        return $this->errors;
    }

//    region OLD_DATA
//    public static function isEmail(string $email): bool
//    {
//        return filter_var($email, FILTER_VALIDATE_EMAIL);
//    }

//    public static function isName(string $name): bool
//    {
//        // only letters and one or zero "-" in one-two words
//        return preg_match('/^([a-zA-Zа-яА-Я]+(-?){0,1}\s?){1,2}$/u', $name);
//    }
//
//    public static function validateLogin(string $login): bool
//    {
//        return preg_match('/^[a-zA-Z0-9]{3,30}$/u', $login);
//    }
//
//    public static function validatePassword(string $login): bool
//    {
//        return preg_match('/^[a-zA-Z|^!-@~`}{_\[\]]{6,30}$/u', $login);
//    }
//
//    public static function isDate(string $date): bool
//    {
//        return preg_match('/^\d{4}-\d{2}-\d{2}$/', $date);
//    }
//    endregion OLD_DATA
}
