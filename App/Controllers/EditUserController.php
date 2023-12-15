<?php

namespace App\Controllers;

use App\Models\User;
class EditUserController extends AbstractController
{
    public function actionEdit($userId)
    {
        $user = (new User())->findById($userId);

        return $this->render('users/edit', ['user' => $user]);
    }
}