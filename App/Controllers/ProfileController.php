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
}
