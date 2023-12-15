<?php

namespace App\Controllers;

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

        try {
            $user = $request->authenticate();

            $_SESSION['user_id'] = $user->id;
            $userToken = md5(uniqid());

            // add cookie to params
            app()->cookie->setCookie('token', $userToken);

            header('Location: /');
        } catch (ValidationException $e) {
            echo $this->render('auth/index', ['errors' => $e->getErrors()]);
        }
    }

    public function actionRegister(): void
    {
        $request = new UserRegisterRequest();
        if ($request->isGet()) {
            echo $this->render('auth/register');
            return;
        }

        try {
            $isCreated = $request->register();

            if ($isCreated) {
                header('Location: /');
            }
        } catch (ValidationException $e) {
            http_response_code(422);
            echo $this->render('auth/register', ['errors' => $e->getErrors()]);
        }
    }
}