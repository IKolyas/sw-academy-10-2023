<?php

namespace App\FormRequests;

use App\Base\Request;
use App\FormRequests\Validators\RecordValidator;

class RecordsApiRequest extends Request
{
    public function validated(): array
    {
        $data = $this->getBody();

        $fields = [
            'id' => $data['id'] ?? null,
            'status' => $data['status'] ?? null,
        ];

        $recordValidator = new RecordValidator();

        $recordValidator->validateId($fields['id']);
        $recordValidator->validateStatus($fields['status']);

        return $fields;

    }
}