<?php

namespace App\FormRequests\Validators;

class UserPhotoValidator extends AbstractValidator
{
    public static function validateUserPhoto(mixed $file): int|bool
    {
        $allowFormat = ['jpeg', 'png', 'jpg'];
        $fileExt = pathinfo($file['name'], PATHINFO_EXTENSION);

        if (!in_array($fileExt, $allowFormat)) {
            return false;
        }

        return true;
    }
}
