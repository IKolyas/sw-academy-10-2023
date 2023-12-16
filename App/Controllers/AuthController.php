<?php

namespace App\Controllers;

use App\Base\Session;
use App\Exceptions\ValidationException;
use App\FormRequests\UserAuthRequest;
use App\FormRequests\UserRegisterRequest;
use App\Models\User;

class AuthController extends AbstractController
{

    public function actionIndex(): void
    {
        $request = new UserAuthRequest();

        if ($request->isGet()) {
            echo $this->render('auth/index');
            return;
        }

        $data = $request->validated();
        $session = new Session();
        $errors = $request->errors();

        if (!empty($errors)) {
            $errors['user'] = 'Неверные данные';
            $session->set('errors', $errors);
            header('Location: /auth');
        }

        $users = new User();

        $user = $users->find($data['login'], 'login');


        $session = new Session();

        if (!$user) {
            $errors['user'] = 'Неверные данные';
            $session->set('errors', $errors);
            header('Location: /auth');
        }

        $passMatch = password_verify($data['password'], $user->password);

        if (!$passMatch) {
            $errors = $session->get('errors');
            $errors['user'] = 'Неверные данные';
            $session->set('errors', $errors);
        }

        (new Session())->set('user_id', $user->id);
        $userToken = md5(uniqid());

        // add cookie to params
        app()->cookie->setCookie('token', $userToken);

        header('Location: /');
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