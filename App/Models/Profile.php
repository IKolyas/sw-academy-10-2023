<?php

namespace App\Models;

use App\Repositories\ProfileRepository;
use App\Repositories\UserRepository;

class Profile extends AbstractModel
{
    public int $id;
    public ?string $first_name;
    public ?string $last_name;
    public string $login;
    public string $password;
    public string $email;
    public int $is_admin;
    public ?string $access_token;
    public string $created_at;
    public string $updated_at;
    public int $status;

    public function __construct()
    {
        $this->repository = new UserRepository();
    }
}
