<?php
/** @var array|null $users */

?>


<div class="table">
    <div class="table-row">
        <div class="table-head">ID</div>
        <div class="table-head">Имя</div>
        <div class="table-head">Фамилия</div>
        <div class="table-head">Email</div>
        <div class="table-head">Логин</div>
        <div class="table-head">Пароль</div>
    </div>
    <?php
    foreach ($users as $user) : ?>
        <div class="table-row">
            <div class="table-cell"><?= $user->id ?></div>
            <div class="table-cell"><?= $user->first_name ?></div>
            <div class="table-cell"><?= $user->last_name ?></div>
            <div class="table-cell"><?= $user->email ?></div>
            <div class="table-cell"><?= $user->login ?></div>
            <div class="table-cell"><?= $user->password ?></div>
        </div>
    <?php
    endforeach; ?>
</div>
