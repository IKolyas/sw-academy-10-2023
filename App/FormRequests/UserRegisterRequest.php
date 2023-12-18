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
        $fields = [];

        foreach ($this->errors as $field => $value) {
            $fields[$field] = $this->getParam($field) ?? null;
            $value = $fields[$field];

            if ($value && UserAuthValidator::validateField($field, $value)) {
                unset($this->errors[$field]);
                continue;
            }

            unset($fields[$field]);
        }

        if ($fields['password'] !== $fields['confirm_password']) {
            $this->errors['confirm_password'] = 'Пароли не совпадают';
        }

        unset($fields['confirm_password']);

        if (!empty($this->errors)) {
            app()->session->set('errors', $this->errors);
        }

        return $fields;
    }

    public function errors(): array
    {
        return $this->errors;
    }
}
