<?php

namespace App\Services;

use App\Enums\EnvModeType;

readonly class AppEnvMode
{
    public static function setMode(EnvModeType|null $modeType): void
    {
        if ($modeType === EnvModeType::DEVELOPMENT) {
            ini_set('display_errors', '1');
            ini_set('display_startup_errors', '1');
            error_reporting(E_ALL);

        }
    }
}