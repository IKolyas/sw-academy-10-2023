
<?php /** @var Edit|null $user */

use App\Models\Edit; ?>

<h2><?php echo $user->first_name?></h2>

<?php if ($user !== null): ?>
    <form class="table" action="" method="post">
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
