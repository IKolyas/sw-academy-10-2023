<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class ValidationException extends Exception {

    public function __construct($message = "", $code = 0, Throwable $previous = null) {
        parent::__construct(json_encode($message), $code, $previous);
    }

    public function getErrors(): array
    {
        return json_decode($this->getMessage(), true);
    }
}