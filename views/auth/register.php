<?php

?>
<form class="form" action="" method="post">
    <div class="form__heading">
        <h2>
            <a class="link" href="/auth">Авторизация</a>
        </h2>
        /
        <h2>
            Регистрация
        </h2>
    </div>
    <?php if (isset($errors['user'])): ?>
        <span class="error"><?= $errors['user'] ?></span>
    <?php endif; ?>
    <div class="form__input-wrapper">
        <label class="form__input">
            Имя
            <input class="input" type="text" value="<?= $_REQUEST['first_name'] ?? '' ?>" name="first_name">
        </label>
        <?php if (isset($errors['first_name'])): ?>
            <span class="error"><?= $errors['first_name'] ?></span>
        <?php endif; ?>
    </div>
    <div class="form__input-wrapper">
        <label class="form__input">
            Фамилия
            <input class="input" type="text"  value="<?= $_REQUEST['last_name'] ?? '' ?>"  name="last_name">
        </label>
        <?php if (isset($errors['last_name'])): ?>
            <span class="error"><?= $errors['last_name'] ?></span>
        <?php endif; ?>
    </div>
    <div class="form__input-wrapper">
        <label class="form__input">
            Логин
            <input class="input" type="text" value="<?= $_REQUEST['login'] ?? '' ?>"  name="login">
        </label>
        <?php if (isset($errors['login'])): ?>
            <span class="error"><?= $errors['login'] ?></span>
        <?php endif; ?>
    </div>
    <div class="form__input-wrapper">
        <label class="form__input">
            Пароль
            <input class="input" type="password" value="<?= $_REQUEST['password'] ?? '' ?>"  name="password">
        </label>
        <?php if (isset($errors['password'])): ?>
            <span class="error"><?= $errors['password'] ?></span>
        <?php endif; ?>
    </div>
    <div class="form__input-wrapper">
        <label class="form__input">
            Подтверждение пароля
            <input class="input" type="password" value="<?= $_REQUEST['confirm_password'] ?? '' ?>"  name="confirm_password">
        </label>
        <?php if (isset($errors['confirm_password'])): ?>
            <span class="error"><?= $errors['confirm_password'] ?></span>
        <?php endif; ?>
    </div>
    <div class="form__input-wrapper">
        <label class="form__input">
            Почта
            <input class="input" type="text" value="<?= $_REQUEST['email'] ?? '' ?>"  name="email">
        </label>
        <?php if (isset($errors['email'])): ?>
            <span class="error"><?= $errors['email'] ?></span>
        <?php endif; ?>
    </div>
    <button class="button" type="submit">Зарегистрироваться</button>
</form>