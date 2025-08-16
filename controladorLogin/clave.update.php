<?php
session_start();
require_once '../lib/csrf.php';
require_once '../modeloLogin/login.modelo.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login/login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || !verifyCsrfToken($_POST['csrf_token'])) {
        die('CSRF token inválido.');
    }
    $clave_actual = $_POST['clave_actual'] ?? '';
    $clave_nueva = $_POST['clave_nueva'] ?? '';

    if (empty($clave_actual) || empty($clave_nueva)) {
        $error = 'Ambos campos son requeridos.';
    } else {
        $login = new LoginModelo();
        $user = $login->verificarUsuario($_SESSION['username'], $clave_actual);
        if ($user) {
            $hash = password_hash($clave_nueva, PASSWORD_DEFAULT);
            $sql = "UPDATE usuarios SET clave_hash = :hash WHERE id = :id";
            $stmt = $login->db->prepare($sql);
            $stmt->bindParam(':hash', $hash, PDO::PARAM_STR);
            $stmt->bindParam(':id', $_SESSION['user_id'], PDO::PARAM_INT);
            $stmt->execute();
            $mensaje = 'Clave actualizada correctamente.';
        } else {
            $error = 'Clave actual incorrecta.';
        }
    }
}
$csrf_token = generateCsrfToken();
?>
<form method="POST">
    <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
    <input type="password" name="clave_actual" placeholder="Clave actual" required>
    <input type="password" name="clave_nueva" placeholder="Clave nueva" required>
    <button type="submit">Actualizar clave</button>
    <?php if (isset($error)) echo "<p>$error</p>"; ?>
    <?php if (isset($mensaje)) echo "<p>$mensaje</p>"; ?>
</form>