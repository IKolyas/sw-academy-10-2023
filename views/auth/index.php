<?php
function redirect(string $url) {
    header('Location: ' . $url);
    exit;
}
?>
<form class="form" action="" method="post">
    <div class="form__heading">
        <h2>Авторизация</h2>
        /
        <h2>
            <a class="link" href="/auth/register">Регистрация</a>
        </h2>
    </div>
    <div class="form__input-wrapper">
        <?php if (isset($errors['user'])): ?>
            <span class="error"><?= $errors['user'] ?></span>
        <?php endif; ?>
        <label class="form__input">
            Логин
            <input class="input" type="text" name="login">
        </label>
        <?php if (isset($errors['login'])): ?>
            <span class="error"><?= $errors['login'] ?></span>
        <?php endif; ?>
    </div>
    <div class="form__input-wrapper">
        <label class="form__input">
            Пароль
            <input class="input" type="password" name="password">
        </label>
        <?php if (isset($errors['password'])): ?>
            <span class="error"><?= $errors['password'] ?></span>
        <?php endif; ?>
    </div>
    <button class="button" type="submit">Войти</button>
</form>