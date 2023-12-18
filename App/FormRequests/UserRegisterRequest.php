<?php

namespace App\FormRequests;

use App\Base\Request;
use App\Base\Session;
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
        $session = new Session();

        $fields = [
            'first_name' => $this->getParam('first_name') ?? null,
            'last_name' => $this->getParam('last_name') ?? null,
            'login' => $this->getParam('login') ?? null,
            'password' => $this->getParam('password') ?? null,
            'confirm_password' => $this->getParam('confirm_password') ?? null,
            'email' => $this->getParam('email') ?? null,
        ];

        foreach ($fields as $field => $value) {
            if ($value && UserAuthValidator::validateField($field, $value)) {
                unset($this->errors[$field]);
            } else {
                unset($fields[$field]);
            }
        }

        if ($fields['password'] !== $fields['confirm_password']) {
            $this->errors['confirm_password'] = 'Пароли не совпадают';
        }

        unset($fields['confirm_password']);

        if (!empty($this->errors)) {
            $session->set('errors', $this->errors);
        }

        return $fields;
    }

    public function errors(): array
    {
        return $this->errors;
    }
}
