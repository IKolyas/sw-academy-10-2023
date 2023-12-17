<?php

namespace App\Controllers;

use App\Base\Session;
use App\FormRequests\UserAuthRequest;
use App\FormRequests\UserRegisterRequest;
use App\Models\User;
use App\Services\Auth;
use App\Services\Renderers\RendererInterface;

class AuthController extends AbstractController
{
    private Session $session;
    private Auth $auth;

    public function __construct(RendererInterface $renderer)
    {
        parent::__construct($renderer);

        $this->session = new Session();

        $this->auth = new Auth();

        $this->session->remove('errors');

        if ($this->auth->isAuthorized()) {
            header('Location: /');
        }
    }

    public function actionIndex(): void
    {
        echo $this->render('auth/login');
    }

    public function actionLogout(): void
    {
        $this->auth->logout();
        header('Location: /auth');
    }

    public function actionLogin(): void
    {
        $request = new UserAuthRequest();

        $data = $request->validated();

        if ($this->auth->authorized($data)) {
            header('Location: /');
        } else {
            $errors = $this->session->get('errors');
            echo $this->render('auth/login', ['errors' => $errors]);
        }
    }

    public function actionRegister(): void
    {
        $request = new UserRegisterRequest();
        if ($request->isGet()) {
            echo $this->render('auth/register');
            return;
        }

        $data = $request->validated();

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

        if ($isCreated) {
            header('Location: /');
        }
    }
}