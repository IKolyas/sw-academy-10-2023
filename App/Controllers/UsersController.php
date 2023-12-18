<?php

namespace App\Controllers;

use App\FormRequests\UserAuthRequest;
use App\Models\User;
use Exception;

class UsersController extends AbstractController
{
//    protected string $mainTemplate = 'layouts/users';
    /**
     * @throws Exception
     */

    public function actionIndex(): void
    {
        $this-> mainTemplate = 'layouts/users';
        $user = new User();
        $users = $user->findAll();

        if ($users) {
            echo $this->render('users/users', ['users' => $users]);
        } else {
//            TODO: Добавить обработку ошибок
            throw new Exception('Users not found');
        }
    }

    /**
     * @throws Exception
     */
    public function actionAuth(?UserAuthRequest $request): void
    {
        $data = $request->validated();

        var_dump($data);
    }

    public function actionAll(array $params): void
    {
        var_dump('test');
    }
}
