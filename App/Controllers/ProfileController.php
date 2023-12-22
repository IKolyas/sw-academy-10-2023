<?php

namespace App\Controllers;

use App\Enums\UserStatusType;
use App\FormRequests\UserEditRequest;
use App\Models\User;
use App\Resources\Users\UserResource;
use App\FormRequests\UserPhotoRequest;
use App\Services\Files;


class ProfileController extends AbstractController
{
    public function actionEdit(): void
    {
        echo $this->render('profile/edit', [
            'user' => UserResource::transformToShow(app()->auth->user),
            'statuses' => UserStatusType::getList(),
        ]);
    }

    public function actionUpdate(?UserEditRequest $request): void
    {
        $user = app()->auth->user;

        if (!$user?->id) {
            $this->renderer->render(self::NOT_FOUND_PAGE_NAME);
            return;
        }

        $data = $request->validated();
        $errors = app()->session->get('errors');

        if (empty($errors)) {
            $user->update($data + ['id' => $user->id]);
        }

        echo $this->render('profile/edit',
            [
                'user' => UserResource::transformToShow($user->find($user->id)),
                'statuses' => UserStatusType::getList(),
                'errors' => app()->session->get('errors'),
            ]
        );
    }

    public function actionChangePassword(?UserEditRequest $request): void
    {
        if ($request->isGet()) {
            echo $this->render('profile/changePassword');
            return;
        }

        $user = app()->auth->user;
        $password = $request->validatedPasswordChange($user);
        $errors = app()->session->get('errors');

        if (!empty($errors)) {
            echo $this->render('profile/changePassword', [
                'errors' => app()->session->get('errors'),
            ]);
            return;
        }

        $user->updatePassword($password + ['id' => $user->id]);
        app()->response->redirect('/profile/edit');
    }

    public function actionUpload(?User $user, ?UserPhotoRequest $request, Files $files): void
    {
        $file = $request->validated();
        $user = app()->auth->user;

        if (!$file) {
            echo $this->render(
                'profile/edit',
                [
                    'user' => $user,
                    'errors' => app()->session->get('errors'),
                    'feedback' => app()->session->get('feedback'),
                    ]
                );
                return;
            }

        $uploadName = $user?->id . '_' . basename($file['name']);
        $files->uploadFile($uploadName);
        $files->updatePhotoInDataBase($user, $uploadName);

        echo $this->render(
            'profile/edit',
            [
                'user' => $user,
                'errors' => app()->session->get('errors'),
                'feedback' => app()->session->get('feedback'),
            ]
        );
    }
}