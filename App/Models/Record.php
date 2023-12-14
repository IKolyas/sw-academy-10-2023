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

    /* public function update($fields): int
    {
        if (isset($fields['password'])) {
            unset($fields['password']);
        }
        parent::update($fields);

        return true;
    } */

    public function add(array $data): bool
    {

        if ($this->isValid($data)) {


            return true;
        } else {

            return false;
        }

        
    }

    private function isValid(array $data): bool
    {
        //TODO: ПРОВЕРКА ВСЕ ЛИ ДАННЫЕ ОТПРАВЛЕНЫ
        foreach ($data as $key=>$record) {

        }
    
        return true;
    }
}