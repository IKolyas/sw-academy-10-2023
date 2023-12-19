<?php

namespace App\Controllers;

use App\FormRequests\UserEditRequest;
use App\Models\User;
use App\Resources\Users\UserResource;


class ProfileController extends AbstractController
{

    public function actionEdit(?User $user): void
    {
        $token = app()->cookie->getCookie('token');
        $user = $user?->find($token,'access_token');

        if (!$user || !$user->id) {
            app()->auth->logout();
            app()->response->redirect('/login');
            return;
        }

        echo $this->render('profile/edit', ['user' => UserResource::transformToShow($user)]);
    }

    public function actionUpdate(?User $user, ?UserEditRequest $request): void
    {
        $token = app()->cookie->getCookie('token');
        $user = $user?->find($token,'access_token');

        if (!$user?->id) {
            $this->renderer->render(self::NOT_FOUND_PAGE_NAME);
            return;
        }

        $data = $request->validated();
        $errors = app()->session->get('errors');

        if (empty($errors)) {
            $user->update($data + ['id' => $user->id]);
        }

        echo $this->render('profile/edit',
            [
                'user' => UserResource::transformToShow($user->find($user->id)),
                'errors' => app()->session->get('errors'),
            ]
        );
    }

const UPLOAD_DIR_ACCESS_MODE = 0777;
const UPLOAD_MAX_FILE_SIZE = 3145728;
const UPLOAD_ALLOWED_MIME_TYPES = [
    'image/jpeg',
    'image/png',
    'image/jpg',
];

public function actionUpload(?User $user, ?UserEditRequest $request): void
{
     
    // $data = $request->validated();
    // $errors = app()->session->get('errors');
     
    // if (empty($errors)) {
    //     $user->update($data + ['id' => $user->id]);
    // }        
     
    // if (!$user?->id) {
    //     $this->renderer->render(self::NOT_FOUND_PAGE_NAME);
    //     return;
    // }

    $token = app()->cookie->getCookie('token');
    $user = $user?->find($token, 'access_token');
    
    // print_r($user->id);
    
    $file = $_FILES['userfile'];
    
    $uploaddir = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'uploads/';
    $uploadfile = $uploaddir . $user->id . '_' . basename($file['name']);
    $uploadFileInDb = 'uploads' . DIRECTORY_SEPARATOR . $user->id . '_' . basename($file['name']);
    // var_dump($uploadfile);

    $user->update(['photo' => $uploadFileInDb, 'id' => $user->id]);
    // $user->photo = $uploadfile;
    // echo '********';
    // print_r($user->photo);
    // die();
    // $data = $request->validated();

    // $user->update('photo' = $user->photo);

    // $errors = app()->session->get('errors');

    // if (empty($errors)) {
        // $record->update($user);
    // }


    print_r($uploadfile);



    $files1 = scandir($uploaddir);
    // print_r($files1);

    if (file_exists($uploadfile)) {
        echo 'Файл уже существует';
        // return;
    }

    $name = $file['name'];
    $type = $file['type'];
    $tmpName = $file['tmp_name'];
    $error = $file['error'];
    $size = $file['size'];

    // $name = $_FILES['userfile']['name']; 
    $ext = pathinfo($name, PATHINFO_EXTENSION); 
    // print_r($ext);

    if( $ext == 'jpeg' || $ext == 'png' || $ext == 'jpg' ) {
        echo '<pre>';
        if (move_uploaded_file($file['tmp_name'], $uploadfile)) {
            echo "Файл корректен и был успешно загружен.\n";
        } else {
            echo $error;
            echo "Возможная атака с помощью файловой загрузки!\n";
        }
        
        echo 'Некоторая отладочная информация:';
        print_r($_FILES);
        print_r($uploadfile);
        print "</pre>";

    } else {
        echo 'error';

         
        echo $this->render(
            'profile/edit',
            [
                'user' => UserResource::transformToShow($user->find($user->id)),
                'errors' => app()->session->get('errors'),
            ]
        );
        return;
    }

    // if ($type = 'image/jpeg' || $type == 'image/png' || $type == 'image/jpg') {


    // } else {
    //     echo 'Тип файла не поддерживается';
    // }
    



    echo $this->render(
        'profile/edit',
        [
            'user' => UserResource::transformToShow($user->find($user->id)),
            'errors' => app()->session->get('errors'),
        ]
    );







    // switch ($error) {
    //     case UPLOAD_ERR_OK: /* There is no error, the file can be uploaded. */
    //         // Validate the file size.
    //         if ($size > self::UPLOAD_MAX_FILE_SIZE) {
    //             echo sprintf('The size of the file "%s" exceeds the maximal allowed size (%s Byte).'
    //                     , $name
    //                     , self::UPLOAD_MAX_FILE_SIZE
    //             );
    //         }

    //         // Validate the file type.
    //         if (!in_array($type, self::UPLOAD_ALLOWED_MIME_TYPES)) {

    //             echo sprintf('The file "%s" is not of a valid MIME type. Allowed MIME types: %s.'
    //                     , $name
    //                     , implode(', ', self::UPLOAD_ALLOWED_MIME_TYPES)
    //             );
    //         }



    //         // break;

    //     case UPLOAD_ERR_INI_SIZE:
    //     case UPLOAD_ERR_FORM_SIZE:
    //         echo sprintf('The provided file "%s" exceeds the allowed file size.'
    //                 , $name
    //         );
    //         // break;

    //     case UPLOAD_ERR_PARTIAL:
    //         echo sprintf('The provided file "%s" was only partially uploaded.'
    //                 , $name
    //         );
    //         // break;

    //     case UPLOAD_ERR_NO_FILE:
    //         echo 'No file provided. Please select at least one file.';
    //         // break;
    // }
}

}


// public function actionUploaddddd(?User $user, ?UserEditRequest $request, array $files = []) {



//     // Normalize the files list.
//     $normalizedFiles = $this->normalizeFiles($files);

//     // Upload each file.
//     foreach ($normalizedFiles as $normalizedFile) {
//         $uploadResult = $this->uploadFile($normalizedFile);

//         if ($uploadResult !== TRUE) {
//             $errors[] = $uploadResult;
//         }
//     }

//     // Return TRUE on success, or the errors list on failure.
//     return empty($errors) ? TRUE : $errors;
// }

// /**
//  * Normalize the files list.
//  *
//  * @link https://www.php-fig.org/psr/psr-7/#16-uploaded-files PSR-7: 1.6 Uploaded files.
//  *
//  * @param array $files (optional) Files list - as received from $_FILES variable.
//  * @return array Normalized files list.
//  */
// private function normalizeFiles(array $files = []) {
//     $normalizedFiles = [];

//     foreach ($files as $filesKey => $filesItem) {
//         foreach ($filesItem as $itemKey => $itemValue) {
//             $normalizedFiles[$itemKey][$filesKey] = $itemValue;
//         }
//     }

//     return $normalizedFiles;
// }



/**
 * Create a directory at the specified path.
 *
 * @param string $path Directory path.
 * @return $this
 */
// private function createDirectory(string $path) {
//     try {
//         if (file_exists($path) && !is_dir($path)) {
//             throw new UnexpectedValueException(
//             'The upload directory can not be created because '
//             . 'a file having the same name already exists!'
//             );
//         }
//     } catch (Exception $exc) {
//         echo $exc->getMessage();
//         exit();
//     }

//     if (!is_dir($path)) {
//         mkdir($path, self::UPLOAD_DIR_ACCESS_MODE, TRUE);
//     }

//     return $this;
// }