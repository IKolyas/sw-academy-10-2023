<?php

namespace App\Controllers;

use App\Models\User;

class UsersController extends AbstractController
{
    /**
     * @throws \Exception
     */
    public function actionIndex(): void
    {
        $user = new User();
        $users = $user->findAll();

        if ($users) {
            echo $this->render('users/index', ['users' => $users]);
        } else {
//            TODO: Добавить обработку ошибок
            throw new \Exception('Users not found');
        }
    }

}