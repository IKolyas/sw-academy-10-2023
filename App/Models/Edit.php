<?php

namespace App\Models;

use App\Repositories\EditRepository;
use Exception;

class Edit extends AbstractModel
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
        $this->repository = new EditRepository();
    }

    public function findById(int $id): ?AbstractModel
    {
        $user = $this->repository->findById($id);

        if ($user === null) {
            throw new Exception('User not found');
        }

        return $user;
    }
}