<?php

namespace App\Controllers;

use App\Base\Request;
use App\Models\User;
use App\Resources\Users\UserResource;

class ExampleUsersController extends AbstractController
{

    protected string $mainTemplate = 'layouts/example_layout';

    public function actionIndex(User $users): void
    {
        echo $this->render(
            'example_users/index',
            [
                'users' => array_map(UserResource::transformToList(...), $users->findAll() ?? [])
            ]
        );
    }

    public function actionShow(array $params, ?User $user, ?Request $request): void
    {
        if ($user?->id) {
            echo $this->render('example_users/show', ['user' => UserResource::transformToShow($user)]);
            return;
        }

        echo $this->render(self::NOT_FOUND_PAGE_NAME);
    }

    public function actionCreate()
    {
        // TODO
    }

    public function actionUpdate()
    {
        // TODO
    }

    public function actionDestroy()
    {
        // TODO
    }
}
