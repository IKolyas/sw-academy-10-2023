<?php

namespace App\Controllers;

class NotFoundController extends AbstractController
{

    public function actionIndex(): void
    {
        echo $this->render(self::NOT_FOUND_PAGE_NAME);
    }
}
