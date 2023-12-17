<?php

namespace App\FormRequests;

use App\Base\Request;
use App\FormRequests\Validators\RecordValidator;
use Exception;

class RecordRequest extends Request
{
    /**
     * @throws Exception
     */
    public function validated(): array
    {
        $request = new Request();
        
        if ($request->method == 'POST') {

            $fields = $this->validatedPost();

        } elseif ($request->method == 'PUT') {

            $fields = $this->validatedPut();
        } elseif ($request->method == 'DELETE') {

            $fields = $this->validatedDelete();
        }

        return $fields;
    }

    /**Валидация Post-запроса */
    private function validatedPost(): array
    {
        //Обязательные поля
        $fields = [
            'id'        => $this->getParam('id') ?? null,
            'user_id'   => $this->getParam('user_id') ?? null,
            'date'      => $this->getParam('date') ?? null,
            'status'    => $this->getParam('status') ?? null,
            'type'      => $this->getParam('type') ?? null,
        ];

        //проверка на заполненность полей
        if (!RecordValidator::isFieldsFilled($fields)) {
            header('Location: http://localhost:8080/records/add');
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
            header('Location: http://localhost:8080/records/add');
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

        //print_r( $data );die;

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

        if (array_search(false, $fields, true)) {
            header('Location: http://localhost:8080/records/edit');
        }

        return $fields;
    }

     /**Валидация Delete-запроса */
     private function validatedDelete(): array
     {
        $id           = $this->getParam('id') ?? null;
        $fields['id'] = RecordValidator::validateId($id);

        if (array_search(false, $fields, true)) {
            header('Location: http://localhost:8080/records/delete');
        }
        
        return $fields;
     }
}
