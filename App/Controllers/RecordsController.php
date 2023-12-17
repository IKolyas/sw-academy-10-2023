<?php

namespace App\Controllers;

use App\Base\Session;
use App\Models\Record;
use App\FormRequests\RecordRequest;

class RecordsController extends AbstractController
{
    
    public function actionIndex(): void
    {
        $record = new Record();
        $records = $record->findAll();

        if ($records) {
            header('Content-Type: application/json');
            echo json_encode($records);
            //echo $this->render('calendars/index', ['calendars' => $calendars]);

        } else {
            //TODO: Добавить обработку ошибок
            throw new \Exception('Calendars not found');
        }
    }

    /**
     * GET-запросы
     */
    public function actionRecords(array $params): void
    {
        $record = new Record();
        
        if (!empty($params)) {

            $calendars = $record->find($params['id']);

            if ($calendars) {
                header('Content-Type: application/json');
                echo json_encode($calendars);

            } else {
            //TODO: Добавить обработку ошибок
                throw new \Exception('Calendars not found');
            }

        } else {
            throw new \Exception('not found: id');
        }
    }

    /**
     * POST-запрос
     */
    public function actionAdd(): void
    {
        $session = new Session();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            //проверка
            $validator = new RecordRequest();
            $params = $validator->validated();

            $record = new Record();

            if ($record->add($params)) {
                //TODO: Заменить на шаблон
                header('Content-Type: application/json');
                echo json_encode([
                    'status'    => true,
                    'message'   => 'Пользователь успешно создан',
                ]);
            } 
        } elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
            //TODO: Заменить на шаблон
            print_r($session->get('errors-record'));
            $session->remove('errors-record');
        }
    }

    /**
     * PUT-запрос
     */
    public function actionEdit(): void
    {
        $session = new Session();

        if ($_SERVER['REQUEST_METHOD'] == 'PUT') {

            //проверка
            $validator = new RecordRequest();
            $params = $validator->validated();

            $record = new Record();

            $countRows = (int)$record->edit($params);

            if ($countRows > 0) {
                //TODO: Заменить на шаблон
                header('Content-Type: application/json');
                echo json_encode([
                    'status'    => true,
                    'message'   => "Пользователь с id:{$params['id']} обновлен",
                ]);
            } else {
                echo "$countRows строк изменено";
            }
           

        } elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
            //TODO: Заменить на шаблон
            print_r($session->get('errors-record'));
            $session->remove('errors-record');
        }
    }

    /**
     * DELETE-запрос
     */
    public function actionDelete(array $params): void
    {
        $session = new Session();

        if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {

            //проверка
            $validator  = new RecordRequest();
            $params     = $validator->validated();

            $record = new Record();

            $countRows = (int)$record->delete($params['id']);

            if ($countRows > 0) {
                header('Content-Type: application/json');
                echo json_encode([
                    'status' => true,
                    'message' => "Пользователь с id:{$params['id']} удалён",
                ]);
            }
        } elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
            //TODO: Заменить на шаблон
            print_r($session->get('errors-record'));
            $session->remove('errors-record');
        }
    }
    
}