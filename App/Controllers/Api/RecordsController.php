<?php

namespace App\Controllers\Api;

use App\Base\Request;
use App\Base\Response;
use App\FormRequests\Validators\RecordValidator;
use App\Models\Record;

class RecordsController extends AbstractApiController
{
    protected Record $records;
    protected RecordValidator $recordValidator;

    public function __construct()
    {
        parent::__construct();

        $this->records = new Record();
        $this->recordValidator = new RecordValidator();
    }

    public function actionRecords(Request $request, Response $response): void
    {
        $data = $request->getBody();

        $date = $data['date'] ?? date('Y-m');

        $firstDay = $date . '-01';
        $lastDay = $date . '-' . date('t', strtotime($date));

        $records = $this->records->getByRange($firstDay, $lastDay, 'date');

        $response->json([
            'status' => 200,
            'success' => true,
            'data' => $records
        ]);
    }

    public function actionRecord(Request $request, Response $response): void
    {
        $data = $request->getBody();

        $date = date('Y-m-d', strtotime($data['date']));
        $record = $this->records->find($date, 'date');

        $response->json([
            'status' => 200,
            'success' => true,
            'data' => $record
        ]);
    }

    public function actionUpdateStatus(Request $request, Response $response): void
    {
        $data = $request->getBody();

        $this->recordValidator->validateId($data['id']);
        $this->recordValidator->validateStatus($data['status']);

        $errors = app()->session->get('errors');

        if ($errors) {
            $response->json([
                'status' => 400,
                'success' => false,
                'errors' => $errors
            ]);
            return;
        }

        $isUpdated = $this->records->update([
            'id' => $data['id'],
            'status' => $data['status']
        ]);

        $response->json([
            'status' => $isUpdated ? 200 : 500,
            'success' => !!$isUpdated,
            'message' => $isUpdated ? 'Запись обновлена' : 'Не удалось обновить запись'
        ]);
    }
}