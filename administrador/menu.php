<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login/login.php');
    exit();
}
$username = htmlspecialchars($_SESSION['username']);
?>
<!-- Menú seguro para el administrador -->
<nav>
    <ul>
        <li>Bienvenido, <?php echo $username; ?></li>
        <li><a href="../controladorLogin/logout.php">Cerrar sesión</a></li>
        <!-- Otras opciones del menú -->
    </ul>
</nav>