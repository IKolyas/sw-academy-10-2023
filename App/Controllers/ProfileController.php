<?php

namespace App\Controllers;

use App\FormRequests\UserEditRequest;
use App\FormRequests\UserRegisterRequest;
use App\Models\User;
use App\Resources\Users\UserResource;
use App\Services\Renderers\RendererInterface;


class ProfileController extends AbstractController
{

    protected ?User $user;

    public function __construct(RendererInterface $renderer)
    {
        parent::__construct($renderer);

        $token = app()->cookie->getCookie('token');
        $this->user = (new User())->find($token, 'access_token');
    }

    public function actionEdit(): void
    {
        echo $this->render('profile/edit', ['user' => UserResource::transformToShow($this->user)]);
    }

    public function actionUpdate(?UserEditRequest $request): void
    {
        $user = $this->user;

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

    public function actionChangePassword(?UserEditRequest $request): void
    {
        if ($request->isGet()) {
            echo $this->render('profile/changePassword');
            return;
        }

        $user = $this->user;
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