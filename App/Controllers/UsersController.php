<?php

namespace App\Controllers;

use App\FormRequests\UserAuthRequest;
use App\Models\User;
use Exception;

class UsersController extends AbstractController
{
//    protected string $mainTemplate = 'layouts/auth';

    /**
     * @throws Exception
     */
    public function actionIndex(): void
    {

        $user = new User();
        $users = $user->findAll();

        if ($users) {
            echo $this->render('users/index', ['users' => $users]);
        } else {
//            TODO: Добавить обработку ошибок
            throw new Exception('Users not found');
        }
    }

    /**
     * @throws Exception
     */
    public function actionAuth(): void
    {
        $request = new UserAuthRequest();
        $data = $request->validated();

        var_dump($data);
    }

    public function actionAll(array $params): void
    {
        var_dump('test');
    }

}
