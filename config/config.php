<?
namespace app\config;

return [
    'dbInfo' => [
        'host' => 'local',
        'port' => '3333',        
    ],
    'adminInfo' => [
        'login' => 'admin',
        'password' => 'admin',
        'email' => 'admin@localhost',
        'name' => 'Admin',
        'surname' => 'Adminos',
    ],
    'envInfo' => parse_ini_file("./../.env"),
];

