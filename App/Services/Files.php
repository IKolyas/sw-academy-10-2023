<?php

namespace App\Services;

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

  public function updatePhotoInDataBase($user, $uploadName): void
  {
    $user->update(['photo' => $uploadName, 'id' => $user->id]);
    $user->photo = $uploadName;
  }
}