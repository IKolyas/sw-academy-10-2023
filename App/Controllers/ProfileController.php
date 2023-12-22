<?php

namespace App\Controllers;

use App\FormRequests\UserEditRequest;
use App\FormRequests\UserRegisterRequest;
use App\Models\User;
use App\Resources\Users\UserResource;
use App\FormRequests\UserPhotoRequest;
use App\Services\Files;
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
        echo $this->render('profile/edit', [
            'user' => UserResource::transformToShow($this->user),
            'attendant' => $this->attendant,
            'totalDuties' => $this->totalDuties,
            'totalMissedDuties' => $this->totalMissedDuties,
        ]);
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
                'user' => $user,
                // 'user' => UserResource::transformToShow($user->find($user->id)),
                'attendant' => $this->attendant,
                'totalDuties' => $this->totalDuties,
                'totalMissedDuties' => $this->totalMissedDuties,
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

    public function actionUpload(?User $user, ?UserPhotoRequest $request, Files $files): void
    {
        $file = $request->validated();
        $token = app()->cookie->getCookie('token');
        $user = $user?->find($token,'access_token');
        
        
        if (!$file) {
            echo $this->render(
                'profile/edit',
                [
                    'user' => $user,
                    'errors' => app()->session->get('errors'),
                    'attendant' => $this->attendant,
                    'totalDuties' => $this->totalDuties,
                    'totalMissedDuties' => $this->totalMissedDuties,
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
                'attendant' => $this->attendant,
                'totalDuties' => $this->totalDuties,
                'totalMissedDuties' => $this->totalMissedDuties,
                'feedback' => app()->session->get('feedback'),
            ]
        );         
    }    
}