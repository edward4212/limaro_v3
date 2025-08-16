<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        http_response_code(403);
        exit('CSRF token inválido.');
    }
    // Validación y sanitización de entradas
    $usuario = filter_input(INPUT_POST, 'usuario', FILTER_SANITIZE_STRING);
    $clave = password_hash($_POST['clave'], PASSWORD_DEFAULT);
    $correo = filter_input(INPUT_POST, 'correo', FILTER_VALIDATE_EMAIL);

    // Insertar usuario en la BD con consulta preparada
    include_once "conexion.php";
    $sql = "INSERT INTO usuario (usuario, clave, correo) VALUES (?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->execute([$usuario, $clave, $correo]);

    echo "Usuario registrado correctamente";
}
?>