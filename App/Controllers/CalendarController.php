<?php

namespace App\Controllers;

use App\Models\Record;

class CalendarController extends AbstractController
{
    /**
     * @throws \Exception
     */
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

}