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

    public function authorized(array $data): bool
    {
        $this->authorize($data);
        return $this->session->get('user_id');
    }

    public function authorize(array $data): void
    {
        $users = new User();

        $user = $users->find($data['login'], 'login');

        if (!$user) {
            $this->session->add('errors', ['user' => 'Неверные данные']);
        }

        $passMatch = password_verify($data['password'], $user->password);

        if (!$passMatch) {
            $this->session->add('errors', ['user' => 'Неверные данные']);
        }

        (new Session())->set('user_id', $user->id);
        $userToken = md5(uniqid());

        // add cookie to params
        app()->cookie->setCookie('token', $userToken);

    }
}