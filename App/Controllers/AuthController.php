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

        if ($request->isGet()) {
            echo $this->render('auth/login');
            return;
        }

        $data = $request->validated();

        $errors = $this->session->get('errors');

        if (empty($errors) && $this->auth->tryLogin($data)) {
            header('Location: /');
        } else {
            echo $this->render('auth/login', [
                'errors' => $this->session->get('errors'),
                'user' => $data
            ]);
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

        $errors = $this->session->get('errors');

        if (empty($errors) && $this->auth->register($data)) {
            header('Location: /');
        } else {
            echo $this->render('auth/register', [
                'errors' => $this->session->get('errors'),
                'user' => $data
            ]);
        }
    }
}
