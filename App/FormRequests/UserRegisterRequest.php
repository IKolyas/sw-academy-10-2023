<?php

namespace App\FormRequests;

use App\Base\Request;
use App\FormRequests\Validators\UserAuthValidator;

class UserRegisterRequest extends Request
{

    protected array $errors = [
        'first_name' => 'Имя указано неверно',
        'last_name' => 'Фамилия указана неверно',
        'login' => 'Логин указан неверно',
        'password' => 'Пароль указан неверно',
        'confirm_password' => 'Пароли не совпадают',
        'email' => 'Email указан неверно',
    ];

    public function validated(): array
    {

        $fields = [
            'first_name' => $this->getParam('first_name') ?? null,
            'last_name' => $this->getParam('last_name') ?? null,
            'login' => $this->getParam('login') ?? null,
            'password' => $this->getParam('password') ?? null,
            'confirm_password' => $this->getParam('confirm_password') ?? null,
            'email' => $this->getParam('email') ?? null,
        ];

        foreach ($fields as $field => $value) {
            if (UserAuthValidator::validateField($field, $value)) {
                unset($this->errors[$field]);
            }
        }

        if (!empty($this->errors)) {
            return [];
        }

        unset($fields['confirm_password']);
        return $fields;
    }

    public function errors(): array
    {
        return $this->errors;
    }
}