<?php
session_start();
require_once './lib/csrf.php';
require_once './modeloLogin/login.modelo.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ./login/login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || !verifyCsrfToken($_POST['csrf_token'])) {
        die('CSRF token inválido.');
    }
    $correo = trim($_POST['correo'] ?? '');

    if (empty($correo) || !filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $error = 'Correo electrónico inválido.';
    } else {
        $correo = htmlspecialchars($correo);
        $login = new LoginModelo();
        $sql = "UPDATE usuarios SET correo = :correo WHERE id = :id";
        $stmt = $login->db->prepare($sql);
        $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
        $stmt->bindParam(':id', $_SESSION['user_id'], PDO::PARAM_INT);
        $stmt->execute();
        $mensaje = 'Correo actualizado correctamente.';
    }
}
$csrf_token = generateCsrfToken();
?>
<form method="POST">
    <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
    <input type="email" name="correo" required>
    <button type="submit">Actualizar correo</button>
    <?php if (isset($error)) echo "<p>$error</p>"; ?>
    <?php if (isset($mensaje)) echo "<p>$mensaje</p>"; ?>
</form>