<?php

namespace App\Controllers;

use App\FormRequests\UserEditRequest;
use App\Models\User;
use App\Resources\Users\UserResource;
use App\FormRequests\UserPhotoRequest;
use App\Services\Files;

class ProfileController extends AbstractController
{

    public function actionEdit(?User $user): void
    {
        $token = app()->cookie->getCookie('token');
        $user = $user?->find($token,'access_token');

        if (!$user || !$user->id) {
            app()->auth->logout();
            app()->response->redirect('/login');
            return;
        }

        echo $this->render('profile/edit', ['user' => UserResource::transformToShow($user)]);
    }

    public function actionUpdate(?User $user, ?UserEditRequest $request): void
    {
        $token = app()->cookie->getCookie('token');
        $user = $user?->find($token,'access_token');

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
                'user' => $user,
                // 'user' => UserResource::transformToShow($user->find($user->id)),

                'errors' => app()->session->get('errors'),
            ]
        );
    }

    public function actionUpload(?User $user, ?UserPhotoRequest $request, Files $files): void
    {
        $file = $request->validated();
        $token = app()->cookie->getCookie('token');
        $user = $user?->find($token,'access_token');
        $uploadName = $user?->id . '_' . basename($file['name']);

        if (!$file) {
            echo $this->render(
                'profile/edit',
                [
                    'user' => $user,
                    'errors' => app()->session->get('errors'),
                ]
            );
            return;
        }

        $user->photo = $uploadName;
        $files->uploadFile($uploadName);
        $files->updatePhotoInDataBase($user, $uploadName);

        echo $this->render(
            'profile/edit',
            [
                'user' => $user,
                'errors' => app()->session->get('errors'),
            ]
        );         
    }    
}