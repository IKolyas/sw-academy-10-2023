<?php

namespace App\FormRequests;

use App\Base\Request;
use App\FormRequests\Validators\UserAuthValidator;
use App\Models\User;
use App\Services\Auth;

class UserEditRequest extends Request
{
    protected array $errors = [
        'first_name' => 'Имя указано неверно',
        'last_name' => 'Фамилия указана неверно',
        'login' => 'Логин указан неверно',
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


        if (!empty($this->errors)) {
            app()->session->set('errors', $this->errors);
        }

        return $fields;
    }

    public function validatedPasswordChange(User $user): ?array
    {
        $old_password = $this->getParam('old_password') ?? null;
        $password = $this->getParam('password') ?? null;


        if (!password_verify($old_password, $user->password)) {
            app()->session->set('errors', ['password' => 'Неверные данные']);
            return null;
        }

        if (!UserAuthValidator::validatePassword($password)) {
            app()->session->set('errors', ['password' => 'Пароль указан неверно']);
            return null;
        }

        return ['password' => $password];
    }
}