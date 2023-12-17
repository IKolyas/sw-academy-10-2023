<?php

namespace App\FormRequests;

use App\Base\Request;
use App\Base\Session;
use App\FormRequests\Validators\UserAuthValidator;
use App\Models\User;

class UserAuthRequest extends Request
{
    public function validated(): array
    {
        $session = new Session();

        $fields = [
            'login' => $this->getParam('login') ?? null,
            'password' => $this->getParam('password') ?? null,
        ];

        if (!UserAuthValidator::validatePassword($fields['password'])) {
            $session->addToArray('errors', ['password' => 'Некорректный пароль']);
            unset($fields['password']);
        }

        if (!UserAuthValidator::validateLogin($fields['login'])) {
            $session->addToArray('errors', ['login' => 'Некорректный логин']);
            unset($fields['login']);
        }

        return $fields;
    }
}
