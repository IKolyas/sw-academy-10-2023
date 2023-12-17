<?php

namespace App\Controllers;


class ExampleCalendarController extends AbstractController
{
    protected string $mainTemplate = 'layouts/example_layout';

    public function actionIndex(): void
    {
        echo $this->render('example_calendar/index');
    }
}