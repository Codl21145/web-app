<?php
session_start();
require_once "blocks/header.php";
require_once "CRUD.php";
require_once "reg_check.php";

?>

<body>
<form class="form" id="myForm">
    <?php
    if(isset($error))
    {
        echo $error;
    }
    ?>
    <br>
    <label for="username">Username</label>
    <br>
    <input type="text" name="username" id="username">
    <br><br>
    <label for="password">Password</label>
    <br>
    <input type="password" name="password" id="password">
    <br><br>
    <label for="confirm password">Confirm password</label>
    <br>
    <input type="password" name="confirm password" id="confirm password">
    <br><br>
    <label for="email">Email</label>
    <br>
    <input type="email" name="email" id="email">
    <br><br>
    <label for="name">Name</label>
    <br>
    <input type="text" name="name" id="name">
    <br><br>
    <button onclick="myFunction()" type="submit">Register</button>
    <br>
    <?php
    if(isset($message))
    {
        echo $message;
    }
    ?>
</form>

<script>
    <?php
        if(!isset($_SESSION['error_message'])){
            $_SESSION['error_message'] = null;
        }
    ?>
    let JSVAR = "<?=$_SESSION['error_message']?>";

    const myForm = document.getElementById('myForm');

    // обновляет страницу, чтобы правильно отобразилось сообщение об ошибке
    function myFunction() {
        if (JSVAR != null)
        {
            window.location.reload();
        }
    }

    const body = document.body;
    body.append(JSVAR);

    myForm.addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(this);
        const searchParams = new URLSearchParams();

        for (const pair of formData) {
            searchParams.append(pair[0],pair[1],pair[2],pair[3],pair[4]);
        }

        fetch('register.php', {
            method: 'post',
            body: searchParams
        }).then(function (response) {
            return response.text();
        }).then(function (text) {
            console.log(text);
        }).catch(function (error) {
            console.error(error);
        })

    });
</script>
</body>
