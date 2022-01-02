<?php

session_start();

require_once "blocks/header.php";

$_SESSION['error_message'] = null;

if ($identity != null): ?>
    <strong>Hello, <?= $identity ?></strong>
    <br>
    <br>
<?php endif; ?>

<a>Made using php version 8.0.8</a>


