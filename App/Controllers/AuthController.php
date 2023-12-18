<?php

namespace App\Controllers;

use App\FormRequests\UserAuthRequest;
use App\FormRequests\UserRegisterRequest;

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
        app()->response->redirect('/auth');
    }

    public function actionLogin(?UserAuthRequest $request): void
    {
        if ($request->isGet()) {
            echo $this->render('auth');
            return;
        }

        $data = $request->validated();
        $errors = app()->session->get('errors');

        if (empty($errors) && app()->auth->tryLogin($data)) {
            app()->response->redirect('/');
        } else {
            echo $this->render('auth/login', [
                'errors' => app()->session->get('errors'),
                'user' => $data
            ]);
        }
    }

    public function actionRegister(?UserRegisterRequest $request): void
    {
        if ($request->isGet()) {
            echo $this->render('auth/register');
            return;
        }

        $data = $request->validated();
        $errors = app()->session->get('errors');

        if (empty($errors) && app()->auth->register($data)) {
            app()->response->redirect('/auth');
        } else {
            echo $this->render('auth/register', [
                'errors' => app()->session->get('errors'),
                'user' => $data
            ]);
        }
    }
}
