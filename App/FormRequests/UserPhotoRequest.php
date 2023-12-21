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
      app()->session->remove('feedback');

      return null;
    }

    app()->session->remove('errors');
    app()->session->addToArray('feedback', ['photo' => 'Фото загружено.']);

    return $file;
  }
}
