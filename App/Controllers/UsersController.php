<?php

namespace App\Controllers;

use App\Models\User;
use App\Resources\Users\UserResource;

class UsersController extends AbstractController
{
    public function actionIndex(User $users): void
    {
        $allUsers = $users->findAll();

        echo $this->render(
            'users/index',
            [
                'users' => $allUsers
            ]
        );
    }

    public function actionShow(?User $user): void
    {
        if (!$user || !$user->id) {
            echo $this->render(self::NOT_FOUND_PAGE_NAME);
            return;
        }

        echo $this->render('users/show', ['user' => UserResource::transformToShow($user)]);
    }
}
