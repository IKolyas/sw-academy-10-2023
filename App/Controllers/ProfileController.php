<?php

namespace App\Controllers;

use App\Enums\UserStatusType;
use App\FormRequests\UserEditRequest;
use App\Models\User;
use App\FormRequests\UserPhotoRequest;
use App\Services\Files;


class ProfileController extends AbstractController
{
    protected string $page = 'profile';
    protected array $sharedData = ['errors', 'userShow', 'userPhoto'];

    public function actionEdit(): void
    {
        echo $this->render('profile/edit', [
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

        echo $this->render('profile/edit', ['statuses' => UserStatusType::getList()]);
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
            echo $this->render('profile/changePassword');
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
            echo $this->render('profile/edit');
            return;
        }

        $uploadName = $user?->id . '_' . basename($file['name']);
        $files->uploadFile($uploadName);
        $files->updatePhotoInDataBase($user, $uploadName);

        echo $this->render(
            'profile/edit', [
                'feedback' => app()->session->get('feedback')
            ]
        );
    }
}