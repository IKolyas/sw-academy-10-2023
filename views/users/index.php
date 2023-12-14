<?php
/** @var array|null $users */
echo '<br>';
echo '<h2>Страница пользователей</h2>';
echo '<br>';

foreach ($users as $user) {
    echo '<br>' . '<br>' . "<div>id: $user->id</div>";
    echo '<br>' . "<div>first_name: $user->first_name</div>";
    echo '<br>' . "<div>last_name: $user->last_name</div>";
    echo '<br>' . "<div>password: $user->password</div>";
    echo '<br>' . "<div>email: $user->email</div>";
    echo '<br>' . "<div>login: $user->login</div>" . '<br>' . '<br>';
}