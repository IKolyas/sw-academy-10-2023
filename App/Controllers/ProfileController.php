<?php

namespace App\Controllers;

use App\FormRequests\UserEditRequest;
use App\Models\User;
use App\Resources\Users\UserResource;


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
                'user' => UserResource::transformToShow($user->find($user->id)),
                'errors' => app()->session->get('errors'),
            ]
        );
    }

    public function actionUpload(?User $user, ?UserEditRequest $request): void
    {

        $token = app()->cookie->getCookie('token');
        $user = $user?->find($token,'access_token');
        $file = $_FILES['userfile'];
        $name = $file['name'];
        $ext = pathinfo($name, PATHINFO_EXTENSION);
        $uploaddir = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'uploads/';
        $uploadfile = $uploaddir . $user->id . '_' . basename($file['name']);
        $uploadFileInDb = $user->id . '_' . basename($file['name']);


        if( $ext == 'jpeg' || $ext == 'png' || $ext == 'jpg' ) {

            move_uploaded_file($file['tmp_name'], $uploadfile);

            $user->update(['photo' => $uploadFileInDb, 'id' => $user->id]);

            echo $this->render(
                'profile/edit',
                [
                    'user' => UserResource::transformToShow($user->find($user->id)),
                    'errors' => app()->session->get('errors'),
                ]
            ); 

        } else {

            echo 'Данный формат файла не поддерживается';
            
            echo $this->render(
                'profile/edit',
                [
                    'user' => UserResource::transformToShow($user->find($user->id)),
                    'errors' => app()->session->get('errors'),
                ]
            );
        }
    }
}