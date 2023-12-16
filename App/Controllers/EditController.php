<?php

namespace App\Controllers;

use App\Models\Edit;

use Exception;

class EditController extends AbstractController
{

    /**
     * @throws Exception
     */
    public function actionShow(array $params): void
    {
        $this->mainTemplate = 'layouts/edit-users';
        $user = new Edit();
        $userData = $user->findById($params['id']);
        if ($userData) {
            echo $this->render('users/edit-user', ['user' => $userData]);
        } else {
            throw new Exception('User not found');
        }
    }


}
