<?php

namespace App\Controllers;

use App\Models\Record;

class CalendarController extends AbstractController
{

    protected bool $authOnly = true; // проверка авторизации

    /**
     * @throws \Exception
     */
    public function actionIndex(): void
    {
        $record = new Record();
        $records = $record->findAll();

        if ($records) {
            echo $this->render('calendar/index', $records);
        } else {
            //TODO: Добавить обработку ошибок
            throw new \Exception('Calendars not found');
        }
    }

}