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
            RequestMethodType::PUT => $this->validatedPut(),
            RequestMethodType::DELETE => $this->validatedDelete(),
            default => throw new Exception('Неизвестный метод запроса'),
        };
    }

    /**Валидация Post-запроса */
    private function validatedPost(): array
    {
        //Обязательные поля
        $fields = [
            'user_id'   => $this->getParam('user_id') ?? null,
            'date'      => $this->getParam('date') ?? null,
            'status'    => $this->getParam('status') ?? null,
            'type'      => $this->getParam('type') ?? null,
        ];

        //проверка на заполненность полей
        if (!RecordValidator::isFieldsFilled($fields)) {
            header('Location: /records/add');
        }
        //Валидация полей
        $fields['user_id']  = RecordValidator::validateUserId($fields['user_id']);
        $fields['date']     = RecordValidator::validateDate($fields['date']);
        $fields['status']   = RecordValidator::validateStatus($fields['status']);
        $fields['type']     = RecordValidator::validateType($fields['type']);

        //добавляем необязательные поля
        $fields['note'] = $this->getParam('note') ?? null;

        //если возникла ошибка -> редирект
        if (array_search(false, $fields, true)) {
            header('Location: /records/add');
        }

        return $fields;
    }

    /**Валидация Put-запроса */
    private function validatedPut(): array
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
    }

     /**Валидация Delete-запроса */
     private function validatedDelete(): array
     {
        $id           = $this->getParam('id') ?? null;
        $fields['id'] = RecordValidator::validateId($id);

        //если возникла ошибка -> редирект
        if (array_search(false, $fields, true)) {
            header('Location: /records/delete');
        }

        return $fields;
     }
}
