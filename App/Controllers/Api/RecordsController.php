<?php

namespace App\Controllers\Api;

use App\Base\Request;
use App\Base\Response;
use App\Models\Record;

class RecordsController extends AbstractApiController
{
    protected Record $records;

    public function __construct()
    {
        parent::__construct();

        $this->records = new Record();
    }

    public function actionGetRecords(Request $request, Response $response): void
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

    public function actionGetRecord(Request $request, Response $response): void
    {
        $data = $request->getBody();

        $date = date('Y-m-d', strtotime($data['date']));
        $record = $this->records->find($date, 'date');

        $response->json([
            'status' => 200,
            'success' => true,
            'data' => [$record]
        ]);
    }
}