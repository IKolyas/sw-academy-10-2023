<?php
/** @var array|null $users */
<<<<<<< HEAD

?>

=======
?>

<style>
    .table {
        display: grid;
        border: 1px solid #ccc;
        border-collapse: collapse;
        width: 100%;
    }

    .table-row {
        display: grid;
        grid-template-columns: 40px repeat(5, 1fr);
        grid-gap: 0;
        border: 1px solid #ccc;
    }

    .table-head,
    .table-cell {
        padding: 8px;
        text-align: center;
        border-right: 1px solid #ccc;
    }
    .table-cell{

    }

    .table-head {
        font-weight: bold;
        background-color: #f2f2f2;
    }
</style>
>>>>>>> origin/3/users-page-anton

<div class="table">
    <div class="table-row">
        <div class="table-head">ID</div>
        <div class="table-head">Имя</div>
        <div class="table-head">Фамилия</div>
        <div class="table-head">Email</div>
        <div class="table-head">Логин</div>
        <div class="table-head">Пароль</div>
    </div>
<<<<<<< HEAD
    <?php
    foreach ($users as $user) : ?>
=======
    <?php foreach ($users as $user) : ?>
>>>>>>> origin/3/users-page-anton
        <div class="table-row">
            <div class="table-cell"><?= $user->id ?></div>
            <div class="table-cell"><?= $user->first_name ?></div>
            <div class="table-cell"><?= $user->last_name ?></div>
            <div class="table-cell"><?= $user->email ?></div>
            <div class="table-cell"><?= $user->login ?></div>
            <div class="table-cell"><?= $user->password ?></div>
        </div>
<<<<<<< HEAD
    <?php
    endforeach; ?>
=======
    <?php endforeach; ?>
>>>>>>> origin/3/users-page-anton
</div>
