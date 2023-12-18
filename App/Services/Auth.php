<?php

namespace App\Services;

use App\Models\User;

class Auth
{

    public function isAuthorized(): bool
    {
        $token = app()->cookie->getCookie('token');

        if (!$token) {
            return false;
        }

        $users = new User();
        $user = $users->find($token, 'access_token');

        if (!$user) {
            app()->cookie->removeCookie('token');
            return false;
        }

        return true;
    }


    public function tryLogin(array $data): bool
    {
        $this->authorize($data);
//        return $this->isAuthorized();
        return $this->authorize($data);
    }

    public function authorize(array $data): bool
    {
        $users = new User();
        $user = $users->find($data['login'], 'login');

        if (!$user) {
            app()->session->addToArray('errors', ['user' => 'Неверные данные']);
            return false;
        }

        $passMatch = password_verify($data['password'], $user->password);

        if (!$passMatch) {
            app()->session->addToArray('errors', ['user' => 'Неверные данные']);
            return false;
        }

        $this->updateToken($user->id);
        return true;
    }

    public function logout(): void
    {
        $token = app()->cookie->getCookie('token');
        $users = new User();

        $user = $users->find($token, 'access_token');
        $users->update(['id' => $user->id, 'access_token' => null]);

        app()->cookie->removeCookie('token');
    }

    public function register(array $data): bool
    {

        $user = new User();
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        $matchLogin = $user->find($data['login'], 'login');

        if ($matchLogin) {
            app()->session->addToArray('errors', ['user' => 'Пользователь с таким логином уже существует']);
            return false;
        }

        $matchEmail = $user->find($data['email'], 'email');

        if ($matchEmail) {
            app()->session->addToArray('errors', ['user' => 'Пользователь с таким email уже существует']);
            return false;
        }

        $isCreated = $user->create($data);

        if (!$isCreated) {
            app()->session->addToArray('errors', ['user' => 'Что-то пошло не так']);
            return false;
        }

//        $this->updateToken($user);

        return true;
    }

    private function updateToken($userId): void
    {
        $userToken = md5(uniqid());
        (new User())->update(['id' => $userId, 'access_token' => $userToken]);
        app()->cookie->setCookie('token', $userToken);
    }
}
