<?php

namespace App\FormRequests\Validators;

use App\Models\User;
use App\Models\Record;

class RecordValidator extends AbstractValidator
{

    $token = app()->cookie->getCookie('token');
    $user = $user?->find($token,'access_token');
    $file = $_FILES['userfile'];
    $name = $file['name'];
    $ext = pathinfo($name, PATHINFO_EXTENSION);
    $uploaddir = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'uploads/';
    $uploadfile = $uploaddir . $user->id . '_' . basename($file['name']);
    $uploadFileInDb = $user->id . '_' . basename($file['name']);  
    
    if( $ext == 'jpeg' || $ext == 'png' || $ext == 'jpg' ) {

        move_uploaded_file($file['tmp_name'], $uploadfile);

        $user->update(['photo' => $uploadFileInDb, 'id' => $user->id]); //Сохраняем в БД
        $user = UserResource::transformToShow($user->find($user->id)); //Переводим в ресурс           

        echo $this->render(
            'profile/edit',
            [
                'user' => $user,
                'errors' => app()->session->get('errors'),
            ]
        ); 

    } else {

        echo 'Данный формат файла не поддерживается';
        
        echo $this->render(
            'profile/edit',
            [
                'user' => $user,
                'errors' => app()->session->get('errors'),
            ]
        );
    }


    

    public static function validateType(mixed $type): int | bool //мой валидатор
    {
        if (is_null($type) || $type != 0 && $type != 1) {

            app()->session->addToArray('errors', ['record' => 'Некорректный тип']);
            return false;
        }

        return (int)$type;
    }


















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
        if ($status != 0 && $status != 1) {

            app()->session->addToArray('errors', ['record' => 'Некорректный статус']);
            return false;
        }

        return (int)$status;
    }

    public static function validateType(mixed $type): int | bool //мой валидатор
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
