<?php

namespace App\Controllers;

use App\Enums\RecordStatusType;
use App\Models\Record;
use App\FormRequests\RecordRequest;
use App\Models\User;
use App\Resources\Record\RecordResource;
use App\Services\Renderers\RendererInterface;
use Exception;

class RecordsController extends AbstractController
{
    protected ?User $user;

    public function __construct(RendererInterface $renderer)
    {
        parent::__construct($renderer);

        $token = app()->cookie->getCookie('token');
        $this->user = (new User())->find($token, 'access_token');
    }

    /**
     * GET-запросы
     * @throws Exception
     */
    public function actionShow(?Record $record, ?RecordRequest $request): void
    {

        if ($this->user->is_admin !== 1) {
            app()->response->redirect('/forbidden');
            return;
        }

        $users = $request->getUsersList();
        $date = $request->getParam('date');
        $foundRecord = $record->getByDate($date);

        if ($foundRecord) {
            echo $this->renderer->render('record/edit', [
                'record' => $foundRecord,
                'statuses' => RecordStatusType::getList(),
                'users' => $users,
            ]);
        }

        if (!$foundRecord) {
            $record->date = $date;
            $foundRecord = $record;
            echo $this->renderer->render('record/create', [
                'record' => $foundRecord,
                'statuses' => RecordStatusType::getList(),
                'users' => $users,
            ]);
        }
    }

    /**
     * POST-запрос
     * @throws Exception
     */
    public function actionAdd(?RecordRequest $request, ?Record $record): void
    {
        $users = $request->getUsersList();
        $date = $request->getParam('date');
        $validated = $request->validated();
        $errors = app()->session->get('errors');

        if (!empty($errors)) {
            echo $this->render('record/create', [
                'record' => compact('date'),
                'errors' => $errors,
                'users' => $users,
            ]);
            return;
        }

        $record->create($validated);
        app()->response->redirect('/calendar/index?' . 'yearMonth=' . date('Y-m', strtotime($date)));
    }

    /**
     * POST-запрос
     * @throws Exception
     */

    public function actionEdit(?RecordRequest $request, ?Record $record): void
    {
        $users = $request->getUsersList();
        $validated = $request->validated();
        $errors = app()->session->get('errors');

        if (!empty($errors)) {
            echo $this->render('record/edit', [
                'record' => RecordResource::transformToShow($record),
                'errors' => $errors,
                'statuses' => RecordStatusType::getList(),
                'users' => $users,
            ]);
            return;
        }

        $record->update($validated);
        app()->response->redirect(
            '/calendar/index?' . 'yearMonth=' . date('Y-m', strtotime($request->getParam('date')))
        );
    }

    public function actionDelete(?Record $record): void
    {
        if (!$record->id) {
            $this->renderer->render(self::NOT_FOUND_PAGE_NAME);
            return;
        }

        $record->delete($record->id);
        app()->response->redirect('/calendar');
    }
}
