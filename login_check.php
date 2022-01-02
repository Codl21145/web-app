<?php

$_SESSION['error_message'] = null;

function redirect() {
    header('Location: index.php');
    exit;
}

if (isset($_SESSION['identity'])) {
    header('Location: index.php');
    exit;
}

// Проверить отправлена ли форма
$submitted = false;
if ($_SERVER['REQUEST_METHOD']=='POST')
{
    $submitted = true;

    //Получение данных из формы
    $login = $_POST['username'];
    $password = $_POST['password'];

    // Авторизация пользователя
    $salt = "dk43v0"; // соль
    $authenticated = false;
    $users = json_decode(file_get_contents(__DIR__ . '/users.json'), true);
    foreach ($users as $usr)
    {
        if ($usr['username'] == $login && $usr['password'] == md5($password . $salt))
        {
            $authenticated = true;
            $_SESSION['identity'] = $login; // Сохранение данных в сессию


            //redirect(); // Перенаправление пользователя на главную страниц
        }
    }
}
