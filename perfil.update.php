<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        http_response_code(403);
        exit('CSRF token inválido.');
    }
    $correo = filter_input(INPUT_POST, 'correo', FILTER_VALIDATE_EMAIL);
    $id_usuario = $_SESSION['user_id'];

    include_once "conexion.php";
    $sql = "UPDATE usuario SET correo = ? WHERE id_usuario = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->execute([$correo, $id_usuario]);
    echo "Perfil actualizado";
}
?>