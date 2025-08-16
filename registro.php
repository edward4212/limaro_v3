<?php
require_once './lib/csrf.php';
require_once './modeloLogin/login.modelo.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || !verifyCsrfToken($_POST['csrf_token'])) {
        die('CSRF token inválido.');
    }
    $usuario = trim($_POST['usuario'] ?? '');
    $clave = $_POST['clave'] ?? '';

    if (empty($usuario) || empty($clave)) {
        $error = 'Usuario y clave requeridos.';
    } else {
        $usuario = htmlspecialchars($usuario);
        $hash = password_hash($clave, PASSWORD_DEFAULT);
        $login = new LoginModelo();
        $sql = "INSERT INTO usuarios (usuario, clave_hash) VALUES (:usuario, :hash)";
        $stmt = $login->db->prepare($sql);
        $stmt->bindParam(':usuario', $usuario, PDO::PARAM_STR);
        $stmt->bindParam(':hash', $hash, PDO::PARAM_STR);
        $stmt->execute();
        $mensaje = 'Usuario registrado correctamente.';
    }
}
$csrf_token = generateCsrfToken();
?>
<form method="POST">
    <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
    <input type="text" name="usuario" required>
    <input type="password" name="clave" required>
    <button type="submit">Registrar</button>
    <?php if (isset($error)) echo "<p>$error</p>"; ?>
    <?php if (isset($mensaje)) echo "<p>$mensaje</p>"; ?>
</form>