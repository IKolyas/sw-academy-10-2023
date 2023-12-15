<?php

namespace App\Controllers;

use App\Models\User;
use Exception;
use Twig\Environment; // настройки Twig
use Twig\Loader\FilesystemLoader; // настройки Twig







class CalendarController extends AbstractController
{

/**
 * @throws Exception
 */
public function actionIndex(): void
{
    $user = new User();
    $users = $user->findAll();
    
    if ($users) {

        
            echo $this->twig->render('index.twig', ['name' => 'ALEXXXXXX', 'go' => 'here']); // вывод всего сразу
            echo $this->render('users/index', ['users' => $users]);
        } else {
//            TODO: Добавить обработку ошибок
            throw new Exception('Users not found');
        }
    }

    public function actionAll(array $params): void
    {
        var_dump('test');
    }

}
