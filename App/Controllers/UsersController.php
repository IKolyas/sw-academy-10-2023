<?php

namespace App\Controllers;

use App\Models\User;
use App\Resources\Users\UserResource;

class UsersController extends AbstractController
{
    public function actionIndex(User $users): void
    {
        echo $this->render(
            'users/index',
            [
                'users' => array_map(UserResource::transformToList(...), $users->findAll() ?? []),
                'attendant' => $this->attendant,
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
