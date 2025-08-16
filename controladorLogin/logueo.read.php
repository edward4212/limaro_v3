<?php
date_default_timezone_set('America/Bogota');
session_start();
if (!isset($_SESSION['user_id'])) {
    session_unset();
    session_destroy();
    header("Location: ../login/login.php");
    exit();
}
?>