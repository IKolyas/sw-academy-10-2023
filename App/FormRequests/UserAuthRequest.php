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

        $fields = [
            'login' => $this->getParam('login') ?? null,
            'password' => $this->getParam('password') ?? null,
        ];

        if (!UserAuthValidator::validatePassword($fields['password'])) {
            $this->errors['password'] = 'Password is not valid';
        }

        if (!UserAuthValidator::validateLogin($fields['login'])) {
            $this->errors['login'] = 'Login is not valid';
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
