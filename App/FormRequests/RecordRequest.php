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
            //RequestMethodType::PUT => $this->validatedPut(),
            RequestMethodType::DELETE => $this->validatedDelete(),
            default => throw new Exception('Неизвестный метод запроса'),
        };
    }

    /**Валидация Post-запроса */
    private function validatedPost(): array
    {
        //Обязательные поля
        $fields = [
            'user_id',
            'date',
            'status',
            'type',
        ];

        //проверка
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
            return ['is-valid' => false];
        }

        return $correctFields;
    }

    /**Валидация Put-запроса */
    /* private function validatedPut(): array
    {
        $id         = $this->getParam('id') ?? null;
        $putData    = file_get_contents('php://input');
        $data       = (array)json_decode($putData);

        $fields = [];

        foreach ($data as $key=>$value) {

            $fields[$key] = match($key) {
                'user_id'   => RecordValidator::validateUserId($value),
                'date'      => RecordValidator::validateDate($value),
                'status'    => RecordValidator::validateStatus($value),
                'type'      => RecordValidator::validateType($value),
                'note'      => $value,
            };
        }

        $fields['id'] = RecordValidator::validateId($id);

        //если возникла ошибка -> редирект
        if (array_search(false, $fields, true)) {
            header('Location: /records/edit');
        }

        return $fields;
    } */

     /**Валидация Delete-запроса */
     private function validatedDelete(): array
     {
        $id = $this->getParam('id') ?? null;
        $fields['id'] = RecordValidator::validateId($id);

        //если возникла ошибка
        if (array_search(false, $fields, true)) {
            return ['is-valid' => false];
        }

        $correctFields['is-valid'] = true;

        return $fields;
     }
}
