<?php

namespace App\Models;

use App\Repositories\RecordRepository;

class Record extends AbstractModel
{
    public int $id;
    public int $user_id ;
    public string $date;
    public int $is_completed;
    public string $created_at;
    public string $updated_at;

    public function __construct()
    {
        $this->repository = new RecordRepository();
    }

    public function add(array $data): int
    {
        $created_at = (new \DateTime('now'))->format('Y-m-d');
        $updated_at = (new \DateTime('now'))->format('Y-m-d');

        $list = [
            'user_id' => $data['user_id'],
            'date' => $data['date'],
            'is_completed' => $data['is_completed'],
            'created_at' => $created_at,
            'updated_at' => $updated_at,
        ];
        return parent::create($list);
    }

    public function edit(array $data): int
    {
        $updated_at = (new \DateTime('now'))->format('Y-m-d');
        $data['updated_at'] = $updated_at;

        return parent::update($data);
    }
}