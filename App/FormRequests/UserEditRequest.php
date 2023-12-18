<?php

namespace App\FormRequests;

use App\Base\Request;
use App\FormRequests\Validators\UserAuthValidator;

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
}