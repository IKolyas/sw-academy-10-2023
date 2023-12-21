<?php

namespace App\FormRequests;

use App\Base\Request;
use App\FormRequests\Validators\UserPhotoValidator;

class UserPhotoRequest extends Request
{
  public function validated(): ?array
  {
    $file = $this->getFile('userfile');

    if (!UserPhotoValidator::validateUserPhoto($file)) {
      app()->session->addToArray('errors', ['photo' => 'Фото не загружено, произошла ошибка!']);

    return null;    
    }

    app()->session->addToArray('errors', ['photo' => 'Фото загружено.']);

    return $file;
  }
}