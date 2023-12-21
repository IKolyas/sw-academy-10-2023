<?php

namespace App\Controllers\Api;

use App\Base\Request;
use App\Base\Response;
use App\Enums\StatusCode;
use App\FormRequests\RecordsApiRequest;
use App\Models\Record;

class RecordsController extends AbstractApiController
{
    protected Record $records;

    public function __construct()
    {
        parent::__construct();

        $this->records = new Record();
    }

    public function actionRecords(Request $request, Response $response): void
    {
        $data = $request->getBody();

        $date = $data['date'] ?? date('Y-m');

        $firstDay = $date . '-01';
        $lastDay = $date . '-' . date('t', strtotime($date));

        $records = $this->records->getByRange($firstDay, $lastDay, 'date');

        $response->json([
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
            'success' => true,
            'data' => $record
        ]);
    }

    public function actionUpdateStatus(Request $request, Response $response): void
    {

        $data = (new RecordsApiRequest)->validated();

        $errors = app()->session->get('errors');

        if ($errors) {
            $response->json([
                'success' => false,
                'errors' => $errors
            ], StatusCode::BAD_REQUEST);
            exit();
        }

        $isUpdated = $this->records->update($data);

        $response->json([
            'success' => !!$isUpdated,
            'message' => $isUpdated ? 'Запись обновлена' : 'Не удалось обновить запись'
        ], $isUpdated ? StatusCode::CREATED : StatusCode::INTERNAL_SERVER_ERROR);
    }
}