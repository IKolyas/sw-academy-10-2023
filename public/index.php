<?php

include $_SERVER['DOCUMENT_ROOT'] . '/../vendor/autoload.php';

use app\Base\Config;

function getItems(array $arr): string {
    $html = '';
    foreach ($arr as $key => $value) {
        $html .= '<li>' . $key . ': ' . $value . '</li>';
    }
    return $html;
}

$config = Config::getInstance();
$dbConfig = $config->getDbConfig();
$envCongig = $config->getEnvConfig();

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Config</title>
    <style>
        ul {
            list-style: none;
        }
    </style>
</head>
<body>
<?php if ($dbConfig):?>
<h3>DB Config:</h3>
<ul>
    <?= getItems($dbConfig) ?>
</ul>
<?php endif?>
<?php if ($envCongig):?>
<h3>ENV Config:</h3>
<ul>
    <?= getItems($envCongig) ?>
</ul>
<?php endif?>
</body>
</html>
