<?php

namespace App\FormRequests;

use App\Base\Request;
use App\Enums\RequestMethodType;
use App\FormRequests\Validators\RecordValidator;
use App\Models\User;
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
    private function validatedPost(): array | bool
    {
        $fields = [
            'date',
            'user_id',
            'type',
            'status',
        ];

        $correctFields = [];

        foreach ($fields as $field) {
            $correctFields[$field] = $this->getParam($field) ?? null;
            $correctFields[$field] = RecordValidator::validateField($field, $correctFields[$field]);
        }

        $correctFields['id'] = $this->getParam('id') ?? null;
        $correctFields['note'] = trim($this->getParam('note')) ?? null;

        if (array_search(false, $correctFields, true)) {
            return false;
        }

        return $correctFields;
    }

    public function getUsersList(): array
    {
        $users = new User();
        $users = $users->getBy('1', 'status');

        foreach ($users as $key => $user) {
            $users[$key] = [
                'value'=> $user->id,
                'name'=> $user->first_name . ' ' . $user->last_name,
            ];

        }
        return $users;
    }
}
