<<<<<<< HEAD
<?php /** @var Edit|null $user */

use App\Models\Edit; ?>

=======
<?php /** @var EditUser|null $user */

use App\Models\EditUser; ?>

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

<h2><?php echo $user->first_name?></h2>

<?php if ($user !== null): ?>
<<<<<<< HEAD
    <form class="table" action="/submit_form.php" method="post">
        <div class="table-row">
            <div class="table-head">ID</div>
            <div class="table-head">Имя</div>
            <div class="table-head">Фамилия</div>
            <div class="table-head">Email</div>
            <div class="table-head">Логин</div>
            <div class="table-head">Пароль</div>
        </div>
        <div class="table-row">
            <div class="table-cell"><?= $user->id ?></div>
            <input class="table-cell" type="text" name="first_name" value="<?= $user->first_name ?>">
            <input class="table-cell" type="text" name="last_name" value="<?= $user->last_name ?>">
            <input class="table-cell" type="email" name="email" value="<?= $user->email ?>">
            <input class="table-cell" type="text" name="login" value="<?= $user->login ?>">
            <input class="table-cell" type="password" name="password" value="<?= $user->password ?>">
        </div>
        <div>
            <input class="btn-edit" type="submit" value="Сохранить изменения">
        </div>
    </form>
<?php else: ?>
    <p>Пользователь не найден.</p>
<?php endif; ?>


=======
<div class="table">
    <div class="table-row">
        <div class="table-head">ID</div>
        <div class="table-head">Имя</div>
        <div class="table-head">Фамилия</div>
        <div class="table-head">Email</div>
        <div class="table-head">Логин</div>
        <div class="table-head">Пароль</div>
    </div>
    <div class="table-row">
        <div class="table-cell"><?= $user->id ?></div>
        <div class="table-cell"><?= $user->first_name ?></div>
        <div class="table-cell"><?= $user->last_name ?></div>
        <div class="table-cell"><?= $user->email ?></div>
        <div class="table-cell"><?= $user->login ?></div>
        <div class="table-cell"><?= $user->password ?></div>
    </div>
<?php else: ?>
    <p>No user found.</p>
<?php endif; ?>
</div>
>>>>>>> origin/3/users-page-anton
