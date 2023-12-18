<?php

namespace App\Controllers;

use App\Models\Record;

class CalendarController extends AbstractController
{

    // protected bool $authOnly = true; // проверка авторизации

    protected string $mainTemplate = 'layouts/calendar';
    /**
     * @throws \Exception
     */
    public function actionIndex(): void
    {
        $record = new Record();
        $records = $record->findAll();

        if ($records) {
            // header('Content-Type: application/json');

            // echo json_encode($records);
            echo $this->render('calendar/index', $records);

            // print_r ($records);


        } else {
            //TODO: Добавить обработку ошибок
            throw new \Exception('Calendars not found');
        }
    }

}