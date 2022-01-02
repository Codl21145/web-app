<?php

function redirect() {
    header('Location: index.php');
    exit;
}

$message = '';
$error = '';
if ($_SERVER['REQUEST_METHOD']=='POST')
{
    // Проверяет существует ли такое же имя пользователя
    $user = new User($_POST['username'], $_POST["password"], $_POST["email"], $_POST["name"]);
    $users = $user->getUsers();
    foreach ($users as $usr)
    {
        if ($usr['username'] == $user->username)
        {
            $_SESSION['username_match'] = $_POST['username'];
        }
    }

    // Проверяет существует ли такая же почта
    foreach ($users as $usrr)
    {
        if ($usrr['email'] == $user->email)
        {
            $_SESSION['email_match'] = $_POST['email'];
        }
    }

    $usr = trim($_POST['username']);
    $t_usr = preg_replace("/\s+/", "", $usr);

    $pas = trim($_POST['password']);
    $t_pas = preg_replace("/\s+/", "", $pas);

    $name = trim($_POST['name']);
    $t_name = preg_replace("/\s+/", "", $name);

    $password = $_POST['password'];
    $uppercase = preg_match('@[A-Z]@', $password);
    $lowercase = preg_match('@[a-z]@', $password);
    $number    = preg_match('@[0-9]@', $password);
    $specialChars = preg_match('@[^\w]@', $password);

    // Проверка на ошибки при вводе данных
    if (strlen(trim($_POST['username'])) < 6 && strlen(trim($_POST['password'])) < 6 && !strlen(trim($_POST['email'])) && !strlen(trim($_POST['name'])))
    {
        $error = "<label class='text-danger'>Form cannot contain only spaces</label>";
        $_SESSION['error_message'] = 'Form cannot contain only spaces';
    }
    else if (empty($_POST['username']))
    {
        $error = "<label class='text-danger'>Enter username</label>";
        $_SESSION['error_message'] = 'Enter username';
        header("refresh:0;");

    }
    else if (strlen($_POST['username']) < 6)
    {
        $error = "<label class='text-danger'>Username must be at least 6 characters long</label>";
        $_SESSION['error_message'] = 'Username must be at least 6 characters long';
    }
    else if (strlen($usr) > strlen($t_usr))
    {
        $error = "<label class='text-danger'>Username cannot contain spaces</label>";
        $_SESSION['error_message'] = 'Username cannot contain spaces';
    }
    else if (empty($_POST['password']))
    {
        $error = "<label class='text-danger'>Enter password</label>";
        $_SESSION['error_message'] = 'Enter password';
    }
    else if (strlen($pas) > strlen($t_pas))
    {
        $error = "<label class='text-danger'>Password cannot contain spaces</label>";
        $_SESSION['error_message'] = 'Password cannot contain spaces';
    }
    else if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 6)
    {
        $error = "<label class='text-danger'>Password should be at least 6 characters in length and should include at least one upper case letter, one number, and one special character</label>";
        $_SESSION['error_message'] = 'Password should be at least 6 characters in length and should include at least one upper case letter, one number, and one special character.';
    }
    else if (empty($_POST["confirm_password"]))
    {
        $error = "<label class='text-danger'>Enter password again</label>";
        $_SESSION['error_message'] = 'Enter password again';
    }
    else if (strcmp($_POST['confirm_password'], $_POST['password']))
    {
        $error = "<label class='text-danger'>Passwords do not match</label>";
        $_SESSION['error_message'] = 'Passwords do not match';
    }
    else if (empty($_POST["email"]))
    {
        $error = "<label class='text-danger'>Enter email</label>";
        $_SESSION['error_message'] = 'Enter email';
    }
    else if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL))
    {
        $error = "<label class='text-danger'>Enter valid email</label>";
        $_SESSION['error_message'] = 'Enter  valid email';
    }
    else if (empty($_POST["name"]))
    {
        $error = "<label class='text-danger'>Enter name</label>";
        $_SESSION['error_message'] = 'Enter name';
    }
    else if (strlen($_POST['name']) <= 1 || strlen($_POST['name']) >= 3)
    {
        $error = "<label class='text-danger'>Name must 2 characters long</label>";
        $_SESSION['error_message'] = 'Name must be 2 characters long';
    }
    else if (strlen($name) > strlen($t_name))
    {
        $error = "<label class='text-danger'>Name cannot contain spaces</label>";
        $_SESSION['error_message'] = 'Name cannot contain spaces';
    }
    else if (isset($_SESSION['username_match']))
    {
        $error = "<label class='text-danger'>Username already exists</label>";
        $_SESSION['error_message'] = 'Username already exists';
        session_unset();
    }
    else if (isset($_SESSION['email_match']))
    {
        $error = "<label class='text-danger'>Email already exists</label>";
        $_SESSION['error_message'] = 'Email already exists';
        session_unset();
    }
    else
    {
        session_unset();
        if (file_exists('users.json'))
        {
            echo('hello 2    ');
            $current_data = file_get_contents('users.json');
            $array_data = json_decode($current_data, true);

            $salt = "dk43v0"; // соль
            $reg_data = array(
                'id' => rand(1000000, 2000000),
                "username" => $_POST['username'],
                "password" =>  md5($_POST["password"] . $salt), // пароль + соль
                "email" => $_POST['email'],
                "name" => $_POST['name'],
            );

            $array_data[] = $reg_data;
            $final_data = json_encode($array_data);

            if (file_put_contents('users.json', $final_data))
            {
                $_SESSION['username_match'] = null;
                $_SESSION['email_match'] = null;

                $_SESSION['identity'] = $_POST['username'];
                redirect(); // Перенаправление пользователя на главную страницу
            }
        }
        else
        {
            $error = 'JSON File not exits';
        }
    }
}