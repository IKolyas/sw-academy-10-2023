<?php

namespace App\FormRequests;

use App\Base\Request;
use App\Enums\RequestMethodType;
use App\FormRequests\Validators\RecordValidator;
use Exception;

class RecordRequest extends Request
{
    /**
     * @throws Exception
     */
    public function validated(): array | bool
    {
        return match (RequestMethodType::tryFrom($this->method)) {
            RequestMethodType::POST => $this->validatedPost(),
            default => throw new Exception('Неизвестный метод запроса'),
        };
    }

    /**Валидация Post-запроса */
    public function validatedPost(): array | bool
    {
        $fields = [
            'date',
            'user_id',
            'type',
        ];

        $correctFields = [];

        foreach ($fields as $field) {
            $correctFields[$field] = trim($this->getParam($field) ) ?? null;
            $correctFields[$field] = RecordValidator::validateField($field, $correctFields[$field]);
        }

        $correctFields['id'] = $this->getParam('id') ?? null;
        $correctFields['note'] = trim($this->getParam('note')) ?? null;

        if (array_search(false, $correctFields, true)) {
            return false;
        }

        return $correctFields;
    }
}
