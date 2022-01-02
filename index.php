<?php
session_start();
require_once "blocks/header.php";

$_SESSION['error_message'] = null;

if ($identity != null): ?>
<strong>Hello, <?= $identity ?></strong>
<?php endif; ?>

