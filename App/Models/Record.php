<?php

namespace App\Models;

use App\Repositories\RecordRepository;

class Record extends AbstractModel
{
    public int $id;
    public int $user_id ;
    public string $date;
    public int $status;
    public int $type;
    public ?string $note;

    public function __construct()
    {
        $this->repository = new RecordRepository();
    }

    public function getByRange(string $from, string $to, string $field = 'id'): array
    {
        return $this->repository->getByRange($from, $to, $field);
    }

}
