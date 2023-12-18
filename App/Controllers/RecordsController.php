<?php

namespace App\Controllers;

use App\Base\Session;
use App\Enums\RequestMethodType;
use App\Models\Record;
use App\FormRequests\RecordRequest;
use Exception;

class RecordsController extends AbstractController
{

    /**
     * GET-запросы
     * @throws Exception
     */
    public function actionRecords(array $params): void
    {
        $record = new Record();

        if (empty($params['id'])) {
            throw new Exception('not found: id');
        }

        $calendars = $record->find($params['id']);

        if (!$calendars) {
            throw new Exception('Calendars not found');
        }

//        For debug
        header('Content-Type: application/json');
        echo json_encode($calendars);

    }

    /**
     * POST-запрос
     * @throws Exception
     */
    public function actionAdd(?RecordRequest $request): void
    {
        $params = $request->validated();

        $record = new Record();

        if (app()->request->isGet()) {
            print_r(app()->session->get('errors'));
            app()->session->remove('errors');
            return;
        }

        if ($record->create($params)) {
            //TODO: Заменить на шаблон
            header('Content-Type: application/json');
            echo json_encode([
                'status' => true,
                'message' => 'Запись успешно создана',
            ]);
        }
    }

    /**
     * PUT-запрос
     * @throws Exception
     */
    public function actionEdit(?RecordRequest $request): void
    {
        if (app()->request->getMethod() != RequestMethodType::PUT) {
            var_dump(app()->session->get('errors'));
            app()->session->remove('errors-record');
        }

        $params = $request->validated();
        $record = new Record();
        $countRows = (int)$record->create($params);

        if (!$countRows) {
            echo "$countRows строк изменено";
            return;
        }

        header('Content-Type: application/json');

        echo json_encode([
            'status' => true,
            'message' => "Пользователь с id:{$params['id']} обновлен",
        ]);

    }

    /**
     * DELETE-запрос
     * @throws Exception
     */
    public function actionDelete(array $params, ?RecordRequest $request): void
    {
        $session = new Session();

        if (app()->request->getMethod() != RequestMethodType::DELETE) {
            print_r(app()->session->get('errors-record'));
            app()->session->remove('errors-record');
        }

        $params = $request->validated();
        $record = new Record();
        $countRows = $record->delete($params['id']);

        if (!$countRows) {
            return;
        }

        header('Content-Type: application/json');
        echo json_encode([
            'status' => true,
            'message' => "Пользователь с id:{$params['id']} удалён",
        ]);
    }

}
