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

    public function getByDate(string $date): ?self
    {
        $repository = new RecordRepository();
        $result = $repository->getBy($date, 'date');

        if (!empty($result)) {
            return $result[0];
        }

        return null;
    }

    public function getByRange(string $from, string $to, string $field = 'id'): array
    {
        return $this->repository->getByRange($from, $to, $field);
    }
    public function getRecordsWithUsers(string $from, string $to): array
    {
        return $this->repository->getRecordsWithUsers($from, $to);
    }

}
