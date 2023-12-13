<?php

include $_SERVER['DOCUMENT_ROOT'] . '/../vendor/autoload.php';

use app\Base\Config;
use app\Base\Request;

$request = new Request;
$data = $request->getRequest();
print_r($data);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <div class="container d-flex justify-content-center">
        <form action="http://localhost:8080/index.php" method="POST">
            <input class="form-control" name="name" type="text" value="ALEXX" />
            <input class="form-control" name="message" type="text" value="Hello World!" />
            <input class="btn btn-primary" name="test" type="submit" value="Отправить POST запрос" />
        </form>
    </div>

    <div class="container d-flex justify-content-center">
        <form action="http://localhost:8080/index.php" method="GET">
            <input class="form-control" name="name" type="text" value="ALEXX" />
            <input class="form-control" name="message" type="text" value="Hello World!" />
            <input class="btn btn-primary" name="test" type="submit" value="Отправить GET запрос" />
        </form>
    </div>
</body>

</html>

<?php

?>