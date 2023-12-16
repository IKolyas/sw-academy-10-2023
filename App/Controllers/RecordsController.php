<?php

namespace App\Controllers;

use App\Models\Record;

//TODO:УБРАТЬ
use App\Enums\RequestData;

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

        //TODO:УБРАТЬ
        //var_dump($params);die;

        $record = new Record();
        
        //TODO: ЕСЛИ ВЫВОД ВСЕХ ТУТ НУЖЕН------------------------------------------
        /* if (count($params) == 1) {
            $records = $record->findAll();
            
            if ($records) {
                header('Content-Type: application/json');
                echo json_encode($records);
                //echo $this->render('calendars/index', ['calendars' => $calendars]);
    
            } else {
                //TODO: Добавить обработку ошибок
                throw new \Exception('Calendars not found');
            }
            
        } elseif (!empty($params['id'])) {

            $calendars = $record->find($params['id']);

            if ($calendars) {
                header('Content-Type: application/json');
                echo json_encode($calendars);
                //echo $this->render('calendars/index', ['calendars' => $calendars]);

            } else {
            //TODO: Добавить обработку ошибок
                throw new \Exception('Calendars not found');
            }

        } else {
            throw new \Exception('not found');
        } */

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
    public function actionAdd(array $params): void
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (empty($params)) {
                throw new \Exception('Calendars=>POST: not data');
            } else {
                $record = new Record();

                //TODO: Сделать проверку

                if ($record->add($params)) {
                    header('Content-Type: application/json');
                    echo json_encode([
                        'status' => true,
                        'message' => 'Пользователь успешно создан',
                    ]);
                }
                
            }
        }
    }

    /**
     * PUT-запрос
     */
    public function actionEdit(array $params): void
    {
        //var_dump($params);die;
        //TODO: если измененяемое значнение равняется значнению из базы, изменение не происходит и нет оповещения!

        if ($_SERVER['REQUEST_METHOD'] == 'PUT') {

            if (!empty($params['id'])) {
                $putData = file_get_contents('php://input');
                $data = (array)json_decode($putData);

                //TODO: Проверка на id(int)
                $data['id'] = $params['id'];

                $record = new Record();

                if ($record->edit($data) == 1) {
                    header('Content-Type: application/json');
                    echo json_encode([
                        'status' => true,
                        'message' => "Пользователь с id:{$data['id']} обновлен",
                    ]);
                }
            } else {
                throw new \Exception('not found: id');
            }

            
        }
    }

    /**
     * DELETE-запрос
     */
    public function actionDelete(array $params): void
    {
        //TODO: если не находит в бд, то никак не оповещает об этом!

        if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {

            if (!empty($params['id'])) {

                //TODO: проверка на id(int)
                $record = new Record();

                if ($record->delete($params['id']) == 1) {
                    header('Content-Type: application/json');
                    echo json_encode([
                        'status' => true,
                        'message' => "Пользователь с id:{$params['id']} удалён",
                    ]);
                }
            } else {
                throw new \Exception('not found: id');
            }
        }
    }
    
}