<?php

session_start();

// Если пользователь авторизован, взять его данные из сессии
$identity = null;
if (isset($_SESSION['identity'])) {
    $identity = $_SESSION['identity'];
}
?>

<!DOCTYPE html>

<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="initial-scale=1, width=device-width">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <link href="/static/styles.css" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

    <title>Web-app</title>
    <nav class="navbar navbar-expand navbar-light bg-light border">
        <div class="collapse navbar-collapse" id="navbar">
            <span class="navbar-nav mt-2">
                <li class="nav-item"><a class="navbar-brand" href="index.php">Main</a></li>
            </span>
            <span class="navbar-nav mt-2">
                <li class="nav-item"><a class="navbar" href="about.php">About</a></li>
            </span>

            <ul class="navbar-nav ml-auto mt-2">
                <?php if ($identity==null): ?>
                    <li class="nav-item"><a class="nav-link" href="register.php">Register</a></li>
                    <li class="nav-item"><a class="nav-link" href="login.php">Log In</a></li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="logout.php">Log Out</a></li>
                <?php endif; ?>

            </ul>
        </div>
    </nav>
</head>

</html>

