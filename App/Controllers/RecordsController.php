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
        $date = app()->request->getParam('date');
        $foundRecord = Record::getByDate($date);

        if ($foundRecord) {
            echo $this->renderer->render('record/edit', ['record' => $foundRecord]);
        }

        if (!$foundRecord) {
            $record->date = $date;
            $foundRecord = $record;
            echo $this->renderer->render('record/create', ['record' => $foundRecord]);
        }
    }

    /**
     * POST-запрос
     * @throws Exception
     */
    public function actionAdd(?RecordRequest $request, ?Record $record): void
    {
        $validated = $request->validated();

        $errors = app()->session->get('errors');

        if (empty($errors)) {
            $record->update($validated + ['id' => $record->id]);
        }

        if ($record->create($validated)) {
            echo $this->render(
                'record/edit',
                [
                    'record' => $validated,
                    'errors' => app()->session->get('errors')
                ]
            );
        }
    }

    /**
     * POST-запрос
     * @throws Exception
     */

    public function actionEdit(?RecordRequest $request, ?Record $record): void
    {
        $validated = $request->validated();
        $errors = app()->session->get('errors');

        if (empty($errors)) {
            $updated = $record->update($validated + ['id' => $record->id]);

            if (!$updated) {
                app()->session->addToArray('errors', ['record' => 'Не удалось обновить запись']);
            }
        } else {
            echo $this->render('record/edit', [
                'record' => $validated,
                'errors' => $errors,
            ]);
            return;
        }

        $errorsAfterUpdate = app()->session->get('errors');

        echo $this->render('record/edit', [
            'record' => $validated,
            'errors' => $errorsAfterUpdate,
        ]);
    }
}
