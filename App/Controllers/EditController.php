<?php

namespace App\Controllers;

use App\Base\Request;
use App\Models\Edit;

use App\Repositories\EditRepository;
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

    public function actionSave(array $params): void
    {
        $request = new Request();
        if ($request->isPost()) {
            $userId = (int)$request->getParam('id');

            if ($userId) {
                $user = new Edit();
                $user->id = $userId;
                $user->first_name = $_POST['first_name'] ?? null;
                $user->last_name = $_POST['last_name'] ?? null;
                $user->email = $_POST['email'] ?? null;
                $user->login = $_POST['login'] ?? null;

                try {
                    $user->save();
                    header("Location: /edit/show?id={$userId}");
                    exit();
                } catch (Exception $e) {
                    echo 'Ошибка при сохранении данных: ' . $e->getMessage();
                }
            } else {
                echo 'Отсутствует идентификатор пользователя.';
            }
        } else {
            echo 'Данные для сохранения не были получены.';
        }
    }



}
