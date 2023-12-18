<?php

namespace App\Controllers;

use App\FormRequests\UserAuthRequest;
use App\Models\User;
use App\Resources\Users\UserResource;
use Exception;

class UsersController extends AbstractController
{
    protected string $mainTemplate = 'layouts/example_layout';
    public function actionIndex(User $users): void
    {
        echo $this->render(
            'users/users',
            [
                'users' => array_map(UserResource::transformToList(...), $users->findAll() ?? [])
            ]
        );
    }

    /**
     * @throws Exception
     */
    public function actionAuth(?UserAuthRequest $request): void
    {
        $data = $request->validated();

        var_dump($data);
    }
}
