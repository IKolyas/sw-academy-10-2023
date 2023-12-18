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

}
