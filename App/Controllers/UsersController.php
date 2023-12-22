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
                'totalDuties' => $this->totalDuties,
                'totalMissedDuties' => $this->totalMissedDuties,
                'page' => 'users',
            ]
        );
    }

    public function actionShow(?User $user): void
    {
        if (!$user || !$user->id) {
            echo $this->render(self::NOT_FOUND_PAGE_NAME);
            return;
        }

        echo $this->render('users/show', [
            'user' => UserResource::transformToShow($user),
            'attendant' => $this->attendant,
            'totalDuties' => $this->totalDuties,
            'totalMissedDuties' => $this->totalMissedDuties,
            'page' => 'users'
        ]);
    }
}
