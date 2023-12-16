<?php

namespace App\FormRequests;

use App\Base\Request;
use App\Base\Session;
use App\FormRequests\Validators\UserAuthValidator;
use App\Models\User;

class UserAuthRequest extends Request
{
    protected array $errors = [];

    public function validated(): array
    {
        $session = new Session();

        $fields = [
            'login' => $this->getParam('login') ?? null,
            'password' => $this->getParam('password') ?? null,
        ];

        if (!UserAuthValidator::validatePassword($fields['password'])) {
            $session->add('errors', ['password' => 'Некорректный пароль']);
        }

        if (!UserAuthValidator::validateLogin($fields['login'])) {
            $session->add('errors', ['login' => 'Некорректный логин']);
        }

        if (!empty($this->errors)) {
            return [];
        }

        return $fields;
    }

    public function errors(): array
    {
        return $this->errors;
    }
}
