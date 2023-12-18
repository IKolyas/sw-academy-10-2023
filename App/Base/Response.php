<?php

namespace App\Base;

class Response
{
    public function redirect(string $action): void
    {
        header("Location: $action");
    }
}
