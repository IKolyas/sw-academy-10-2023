<?php

include $_SERVER['DOCUMENT_ROOT'] . '/../vendor/autoload.php';

use app\Base\Config;

$config = Config::getInstance();
$dbConfig = $config->getDbConfig();
$envCongig = $config->getEnvConfig();

function template($__view, $__data)
{
    extract($__data);
    ob_start();
    require $__view;
    $output = ob_get_clean();
    return $output;
}

$items = [
    'DB Config' => $dbConfig,
    'Env Config' => $envCongig
];

$listContent = template('../view/list.php', $items);
$pageContent = template('../view/layout.php', [
    'title' => 'sw-academy-10-2023',
    'content' => $listContent
]);

print($pageContent);