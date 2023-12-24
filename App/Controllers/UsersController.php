<?php

namespace App\Controllers;

use App\Enums\UserStatusType;
use App\FormRequests\UserEditRequest;
use App\Models\User;
use App\Resources\Users\UserResource;

class UsersController extends AbstractController
{
    protected string $page = 'users';

    public function actionIndex(User $users): void
    {
        echo $this->render(
            'users/index',
            [
                'users' => array_map(UserResource::transformToList(...), $users->findAll() ?? []),
                'statuses' => UserStatusType::getList()
            ]
        );
    }

    public function actionShow(?User $user): void
    {
        if (!$user || !$user->id) {
            echo $this->render(self::NOT_FOUND_PAGE_NAME);
            return;
        }

        if (app()->auth->user->is_admin)
        {
            echo $this->render('users/edit', [
                'user' => UserResource::transformToShow($user),
                'statuses' => UserStatusType::getList(),
            ]);
            return;
        }

        echo $this->render('users/show', [
            'user' => UserResource::transformToShow($user),
            'statuses' => UserStatusType::getList()
        ]);
    }

    public function actionUpdate(?UserEditRequest $request): void
    {
        $id = $request->getParam('id');

        if (!$id) {
            $this->renderer->render(self::NOT_FOUND_PAGE_NAME);
            return;
        }

        $data = $request->validated();
        $errors = app()->session->get('errors');

        if (empty($errors)) {
            (new User())->update($data + ['id' => $id]);
        }

        echo $this->render('users/edit',
            [
                'user' => UserResource::transformToShow((new User())->find($id) ?? new User()),
                'statuses' => UserStatusType::getList()
            ]);
    }
}
