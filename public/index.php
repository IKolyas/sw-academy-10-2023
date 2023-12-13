<?php

include $_SERVER['DOCUMENT_ROOT'] . '/../vendor/autoload.php';

use app\Base\Config;

$config = Config::getInstance();
$configData = $config->getConfig();
$envConfig = $config->getEnvData();

function template($__view, $__data)
{
    extract($__data);
    ob_start();
    require $__view;
    $output = ob_get_clean();
    return $output;
}

$items = [
    'DB Config' => $configData['db'],
    'Tokenization Config' => $configData['tokenization'],
    'Env Config' => $envConfig
];

$listContent = template('../view/list.php', $items);
$pageContent = template('../view/layout.php', [
    'title' => 'sw-academy-10-2023',
    'content' => $listContent
]);

print($pageContent);