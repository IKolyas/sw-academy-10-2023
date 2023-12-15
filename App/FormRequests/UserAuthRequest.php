<?php

namespace App\FormRequests;

use App\Base\Request;
use App\Exceptions\ValidationException;
use App\FormRequests\Validators\UserAuthValidator;
use App\Models\User;

class UserAuthRequest extends Request
{
    protected array $errors = [];


    /**
     * @throws ValidationException
     */
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
            throw new ValidationException($this->errors);
        }

        return $fields;
    }

    /**
     * @throws ValidationException
     */
    public function authenticate(): User
    {
        $data = $this->validated();

        $user = new User();

        $match = $user->find($data['login'], 'login');

        if (!$match) {
            throw new ValidationException(['user' => 'Неверные данные']);
        }

        $passMatch = password_verify($data['password'], $match->password);

        if (!$passMatch) {
            throw new ValidationException(['user' => 'Неверные данные']);
        }

        return $match;
    }

    public function errors(): array
    {
        return $this->errors;
    }
}
