<?php

namespace App\FormRequests;

use App\Base\Request;
use App\Exceptions\ValidationException;
use App\FormRequests\Validators\UserAuthValidator;
use App\Models\User;

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

    /**
     * @throws ValidationException
     */
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
            throw new ValidationException($this->errors);
        }

        unset($fields['confirm_password']);
        return $fields;
    }

    /**
     * @throws ValidationException
     */
    public function register(): int
    {
        $data = $this->validated();

        $user = new User();

        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

        $matchLogin = $user->find($data['login'], 'login');

        if ($matchLogin) {
            throw new ValidationException(['user' => 'Пользователь с таким логином уже существует']);
        }

        $matchEmail = $user->find($data['email'], 'email');

        if ($matchEmail) {
            throw new ValidationException(['user' => 'Пользователь с таким email уже существует']);
        }

        $isCreated = $user->create($data);

        if ($isCreated) {
            $_SESSION['user_login'] = $data['login'];
        }
        return $isCreated;
    }


}