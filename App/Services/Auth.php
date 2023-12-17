<?php

namespace App\Services;

use App\Base\Session;
use App\Models\User;
use App\Traits\Singleton;

class Auth
{
    private Session $session;

    public function __construct()
    {
        $this->session = new Session();
    }

    public function isAuthorized(): bool
    {
        $token = app()->cookie->getCookie('token') ?? $this->session->get('token');

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
        return $this->isAuthorized();
    }

    public function authorize(array $data): void
    {
        $users = new User();

        $user = $users->find($data['login'], 'login');

        if (!$user) {
            $this->session->addToArray('errors', ['user' => 'Неверные данные']);
            return;
        }

        $passMatch = password_verify($data['password'], $user->password);

        if (!$passMatch) {
            $this->session->addToArray('errors', ['user' => 'Неверные данные']);
            return;
        }

        (new Session())->set('user_id', $user->id);
        $userToken = md5(uniqid());

        app()->cookie->setCookie('token', $userToken);
        $this->session->set('token', $userToken);
        $users->update(['id' => $user->id, 'access_token' => $userToken]);
    }

    public function logout(): void
    {
        $token = app()->cookie->getCookie('token') ?? $this->session->get('token');

        $users = new User();

        $user = $users->find($token, 'access_token');
        $users->update(['id' => $user->id, 'access_token' => null]);

        $this->session->remove('token');
        app()->cookie->removeCookie('token');
    }

    public function register(array $data): bool
    {

        $user = new User();

        $password_dump = $data['password'];
        $data['password'] = password_hash($password_dump, PASSWORD_DEFAULT);

        $matchLogin = $user->find($data['login'], 'login');

        if ($matchLogin) {
            $this->session->addToArray('errors', ['user' => 'Пользователь с таким логином уже существует']);
            return false;
        }

        $matchEmail = $user->find($data['email'], 'email');

        if ($matchEmail) {
            $this->session->addToArray('errors', ['user' => 'Пользователь с таким email уже существует']);
            return false;
        }

        $isCreated = $user->create($data);

        if (!$isCreated) {
            $this->session->addToArray('errors', ['user' => 'Что-то пошло не так']);
            return false;
        }

        $data['password'] = $password_dump;

        return $this->tryLogin($data);
    }

}