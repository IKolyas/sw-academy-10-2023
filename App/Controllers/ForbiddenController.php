<?php

namespace App\Controllers;

class ForbiddenController extends AbstractController
{
    public function actionIndex(): void
    {
        echo $this->render(self::FORBIDDEN_PAGE_NAME);
    }
}