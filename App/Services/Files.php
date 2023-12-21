<?php

namespace App\Services;

use App\Models\User;

class Files
{
  protected ?array $file;
  protected ?string $uploadDir;


  public function __construct()
  {
    $this->file = app()->request->getFile('userfile');
    $this->uploadDir = app()->getConfig('UPLOADS_DIR');
  }

  public function uploadFile($uploadName): void
  {
    $uploadFile = $this->uploadDir . $uploadName;
    move_uploaded_file($this->file['tmp_name'], $uploadFile);  
  }

  public function updatePhotoInDataBase($user, $uploadName)
  {
    $token = app()->cookie->getCookie('token');
    $user = (new User())->find($token,'access_token');        
    $user->photo = $uploadName;  

    $user->update(['photo' => $uploadName, 'id' => $user->id]);
  }
}