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
    private function validatedPost(): array
    {
        //Обязательные поля
        $fields = [
            'id',
            'date',
            'user_id',
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
// TODO: тут проблем
        //если возникла ошибка
        if (array_search(false, $correctFields, true)) {
            return $correctFields;
        }

        return $correctFields;
    }
}
