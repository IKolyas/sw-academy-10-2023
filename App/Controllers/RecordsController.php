<?php

namespace App\Controllers;

use App\Models\Record;
use App\FormRequests\RecordRequest;
use Exception;

class RecordsController extends AbstractController
{

    /**
     * GET-запросы
     * @throws Exception
     */
    public function actionShow(?Record $record): void
    {
        if (!$record->id) {
            echo $this->renderer->render(self::NOT_FOUND_PAGE_NAME);
        }

//        TODO: Заменить на шаблон
//        $this->renderer->render('records/show', ['record' => $record]);
    }

    /**
     * POST-запрос
     * @throws Exception
     */
    public function actionAdd(?RecordRequest $request, ?Record $record): void
    {
        $validated = $request->validated();

        if (!$validated) {
            //TODO: Заменить на шаблон
            var_dump(app()->session->get('errors'));
            return;
        }

        if ($record->create($validated)) {
            //TODO: Заменить на шаблон
            var_dump("Запись успешно создана");
        }
    }

    /**
     * POST-запрос
     * @throws Exception
     */

    public function actionEdit(?RecordRequest $request, ?Record $record): void
    {

        $validated = $request->validated();

        if (!$validated) {
            //TODO: Заменить на шаблон
            var_dump(app()->session->get('errors'));
            return;
        }

        $record->update($validated);

        //TODO: Заменить на шаблон
        var_dump($record, "Запись успешно обновлена");

    }

    /**
     * POST-запрос
     * @throws Exception
     */

    public function actionDelete(?Record $record): void
    {
        if (!$record->id) {
            $this->renderer->render(self::NOT_FOUND_PAGE_NAME);
            return;
        }

        $record->delete($record->id);

        //TODO: Заменить на шаблон
        var_dump("Пользователь с id:{$record->id} удалён");
    }

}
