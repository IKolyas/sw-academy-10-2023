<?php

namespace App\Controllers;

use App\Models\Record;
use App\FormRequests\RecordRequest;
use App\Resources\Record\RecordResource;
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
        $date = app()->request->getParam('date');
        $validated = $request->validated();
        $errors = app()->session->get('errors');

        if (!empty($errors)) {
            echo $this->render('record/create', [
                'record' => ['date' => $date],
                'errors' => $errors,
            ]);
            return;
        }

        $record->create($validated);
        app()->response->redirect('/calendar');
    }

    /**
     * POST-запрос
     * @throws Exception
     */

    public function actionEdit(?RecordRequest $request, ?Record $record): void
    {
        $validated = $request->validated();
        $errors = app()->session->get('errors');

        if (!empty($errors)) {
            echo $this->render('record/edit', [
                'record' => RecordResource::transformToShow($record->find($record->id)),
                'errors' => $errors,
            ]);
            return;
        }

        $validated['status'] = $request->getParam('status') ?? null;
        $record->update($validated);
        app()->response->redirect('/calendar');
    }
}
