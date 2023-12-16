<?php

namespace App\Controllers;

use App\Models\EditUser;

use Exception;

class EditUserController extends AbstractController
{
    protected string $mainTemplate = 'layouts/edit-users';

    public function actionShow(array $params): void
    {
        $user = new EditUser();
        $userData = $user->findById($params['id']);
        if ($userData) {
            echo $this->render('users/edit-user', ['user' => $userData]);
        } else {
            throw new Exception('User not found');
        }
    }
}
