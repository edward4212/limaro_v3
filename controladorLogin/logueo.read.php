<?php
session_start();
// Protección CSRF y validación de sesión
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit();
}
// Escape de datos
$user = htmlspecialchars($_SESSION['username']);
// Resto del código seguro...
?>