<?php
session_start();
require_once "blocks/header.php";
require_once "CRUD.php";
require_once "login_check.php";


?>

<title>Fetch</title>
<body>


<form class="form" id="myForm">
    <label for="username">Username</label>
    <input type="text" name="username" id="username">
    <br>
    <label for="password">Password</label>
    <input type="password" name="password" id="password">
    <br>
    <button onclick="myFunction()" type="submit">Login</button>
</form>

<script>
    let JSVAR = "<?=$_SESSION['error_message']?>";

    const myForm = document.getElementById('myForm');

    // обновляет страницу, чтобы при правильном вводе данных пользователя перенаправило на главную
    function myFunction() {
        if (JSVAR != null)
        {
            window.location.reload();
        }
    }

    myForm.addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(this);
        const searchParams = new URLSearchParams();


        for (const pair of formData) {
            searchParams.append(pair[0],pair[1]);
        }

        fetch('login.php', {
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

<?php
if (isset($_SESSION['identity'])) {
    redirect();
}
//if(isset($_SESSION['identity'])) {header('Location: index.php');}