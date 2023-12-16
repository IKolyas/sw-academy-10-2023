<?php

namespace App\Controllers;

use App\Models\User;
use Exception;

class UsersController extends AbstractController
{

    /**
     * @throws Exception
     */
    public function actionIndex(): void
    {
        $this->mainTemplate = 'layouts/users';
        $user = new User();
        $users = $user->findAll();

        if ($users) {
            echo $this->render('users/users', ['users' => $users]);
        } else {
//            TODO: Добавить обработку ошибок
            throw new Exception('Users not found');
        }
    }

}
