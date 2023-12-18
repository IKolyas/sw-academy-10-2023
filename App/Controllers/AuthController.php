<?php

namespace App\Controllers;

use App\FormRequests\UserAuthRequest;
use App\FormRequests\UserRegisterRequest;
use App\Services\Renderers\RendererInterface;

class AuthController extends AbstractController
{
    protected bool $requireAuth = false;

    public function actionIndex(): void
    {
        echo $this->render('auth/login');
    }

    public function actionLogout(): void
    {
        app()->auth->logout();
        header('Location: /auth');
    }

    public function actionLogin(): void
    {
        $request = new UserAuthRequest();

        if ($request->isGet()) {
            echo $this->render('auth');
            return;
        }

        $data = $request->validated();
        $errors = app()->session->get('errors');

        if (empty($errors) && app()->auth->tryLogin($data)) {
            header('Location: /');
        } else {
            echo $this->render('auth/login', [
                'errors' => app()->session->get('errors'),
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
        $errors = app()->session->get('errors');

        if (empty($errors) && app()->auth->register($data)) {
            header('Location: /auth');
        } else {
            echo $this->render('auth/register', [
                'errors' => app()->session->get('errors'),
                'user' => $data
            ]);
        }
    }
}
