<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ПОЛЬЗОВАТЕЛИ АКАДЕМИЯ 2023</title>
</head>
<style>
    .btn-edit {
        display: inline-block;
        padding: 5px 10px;
        background-color: #4f4caf;
        color: white;
        text-decoration: none;
        border-radius: 4px;
        transition: background-color 0.3s ease;
        margin-bottom: 40px;
    }
</style>
<body>
<header>
    <h1>ПОЛЬЗОВАТЕЛИ "АКАДЕМИЯ 2023"</h1>
</header>

<main class="content">
    <a href="http://localhost:8080/editUser/show?id=3" class="btn-edit">Редактировать</a>
    <?= /** @var string $content */
    $content
    ?>
</main>

<footer>
</footer>
</body>
</html>