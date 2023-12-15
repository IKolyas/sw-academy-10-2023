<?php

namespace App\Models;

use App\Repositories\EditUserRepository;
use Exception;

class EditUser extends AbstractModel
{
    public int $id;
    public string $first_name;
    public string $last_name;
    public string $login;
    public string $email;
    public string $password;
    public int $is_admin;

    public function __construct()
    {
        $this->repository = new EditUserRepository();
    }

    public function findById(int $id): AbstractModel
    {
        $user = $this->repository->findById($id);

        if ($user === null) {
            throw new Exception('User not found');
        }

        return $user;
    }
}