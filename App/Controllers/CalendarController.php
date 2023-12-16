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
        // $renderer = TemplateCalendar::class;
        // var_dump($renderer);
        // exit();

        if ($records) {
            header('Content-Type: application/json');
            // echo json_encode($records);
            echo $this->render('layouts/calendar', ['calendars' => $records]);

        } else {
            //TODO: Добавить обработку ошибок
            throw new \Exception('Calendars not found');
        }
    }

}