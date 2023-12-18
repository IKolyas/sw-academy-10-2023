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
    public function validated(): array
    {
        return match (RequestMethodType::tryFrom($this->method)) {
            RequestMethodType::POST => $this->validatedPost(),
            default => throw new Exception('Неизвестный метод запроса'),
        };
    }

    /**Валидация Post-запроса */
    private function validatedPost(): array | bool
    {
        //Обязательные поля
        $fields = [
            'user_id',
            'date',
            'status',
            'type',
        ];

        $correctFields = [];

        foreach ($fields as $field) {
            $correctFields[$field] = $this->getParam($field) ?? null;
            //валидирует данные
            $correctFields[$field] = RecordValidator::validateField($field, $correctFields[$field]);
        }

        //добавляем необязательные поля
        $correctFields['note'] = $this->getParam('note') ?? null;

        //если возникла ошибка
        if (array_search(false, $correctFields, true)) {
            return false;
        }

        return $correctFields;
    }
}
