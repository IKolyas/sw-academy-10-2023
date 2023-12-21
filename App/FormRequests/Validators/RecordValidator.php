<?php

namespace App\FormRequests\Validators;

use App\Enums\RecordStatusType;
use App\Models\User;
use App\Models\Record;

class RecordValidator extends AbstractValidator
{

    public static function validateId(mixed $id): int | bool
    {
        if (preg_match('/\D/u', $id) || !(new Record())->find($id)) {
            app()->session->addToArray('errors', ['record' => 'Некорректный id']);
            return false;
        }

        return (int)$id;
    }

    public static function validateDate(mixed $date): string | bool
    {
        if (!self::isString($date)) {
            app()->session->addToArray('errors', ['record' => 'Некорректная дата']);

            return false;
        }

        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/u', $date)) {

            if ($timestamp = strtotime($date)) {
                return date("Y-m-d", $timestamp);
            }

            app()->session->addToArray('errors', ['record' => 'Некорректная дата']);

            return false;
        }

        return $date;
    }

    public static function validateUserId(mixed $id): int | bool
    {
        if (is_null($id) || preg_match('/\D/u', $id) || !(new User())->find($id)) {

            app()->session->addToArray('errors', ['record' => 'Некорректный пользователь']);
            return false;
        }

        return (int)$id;
    }

    public static function validateStatus(mixed $status): int | bool
    {
        if ($status != RecordStatusType::WAITING_FOR_DUTY->value && $status != RecordStatusType::DUTY_COMPLETED->value) {

            app()->session->addToArray('errors', ['record' => 'Некорректный статус']);
            return false;
        }

        return (int)$status;
    }

    public static function validateType(mixed $type): int | bool
    {
        if (is_null($type) || $type != 0 && $type != 1) {

            app()->session->addToArray('errors', ['record' => 'Некорректный тип']);
            return false;
        }

        return (int)$type;
    }

    public static function validateField(string $field, ?string $value): mixed
    {
        return match ($field) {
            'id' => self::validateId($value),
            'date' => self::validateDate($value),
            'user_id' => self::validateUserId($value),
            'status' => self::validateStatus($value),
            'type' => self::validateType($value),
            'note' => $value,
        };
    }

}
