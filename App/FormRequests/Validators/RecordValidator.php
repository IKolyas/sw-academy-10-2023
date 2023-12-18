<?php

namespace App\FormRequests\Validators;

use App\Models\User;
use App\Models\Record;

class RecordValidator extends AbstractValidator
{

    public static function isFieldsFilled(array $fields): bool
    {

        if (array_search(null, $fields, true)) {

            $_SESSION["errors-record"]['is-fields-filled'] = 'Fill in all the fields!';
            return false;
        }
        return true;
    }

    public static function validateId(mixed $id): bool|int
    {
        if (preg_match('/\D/u', $id) || !(new Record())->find($id)) {
            
            $_SESSION["errors-record"]['id'] = 'id is not valid';
            return false;
        }

        return (int)$id;
    }

    public static function validateDate(mixed $date): bool|string
    {
        if (!parent::isString($date)) {

            $_SESSION["errors-record"]['date'] = 'Date is not valid';
            return false;
        }

        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/u', $date)) {

            if ($timestamp = strtotime($date)) {
                return date("Y-m-d", $timestamp);
            }
            $_SESSION["errors-record"]['date'] = 'Date is not valid';
            return false;
        } 
        return $date;
    }

    public static function validateUserId(mixed $id): bool|int
    {
        if (preg_match('/\D/u', $id) || !(new User())->find($id)) {

            $_SESSION["errors-record"]['user_id'] = 'User id is not valid';
            return false;
        }

        return (int)$id;
    }

    public static function validateStatus(mixed $status): bool|int
    {
        if ($status != 0 && $status != 1) {

            $_SESSION["errors-record"]['status'] = 'Status is not valid';
            return false;
        }

        return (int)$status;
    }

    public static function validateType(mixed $type): bool|int
    {
        if ($type != 0 && $type != 1) {

            $_SESSION["errors-record"]['type'] = 'Type is not valid';
            return false;
        }

        return (int)$type;
    }

}
