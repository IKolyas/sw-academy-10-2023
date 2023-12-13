<?php

namespace App\Models;

use App\Repositories\UserRepository;

class User extends AbstractModel
{
    public int $id;
    public string $first_name;
    public string $last_name;
    public string $login;
    public string $password;
    public string $email;
    public int $is_admin;

    public function __construct()
    {
        $this->repository = new UserRepository();
    }

    public function update($fields): int
    {
        if (isset($fields['password'])) {
            unset($fields['password']);
        }
        parent::update($fields);

        return true;
    }
}