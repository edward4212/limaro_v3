<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        http_response_code(403);
        exit('CSRF token inválido.');
    }
    if (!isset($_FILES['archivo']) || $_FILES['archivo']['error'] !== UPLOAD_ERR_OK) {
        exit('Error al subir archivo.');
    }
    $archivo = $_FILES['archivo'];
    $permitidos = ['application/pdf', 'image/jpeg', 'image/png'];
    if (!in_array($archivo['type'], $permitidos) || $archivo['size'] > 5 * 1024 * 1024) {
        exit('Archivo inválido.');
    }
    $nombreSeguro = bin2hex(random_bytes(8)) . '_' . basename($archivo['name']);
    move_uploaded_file($archivo['tmp_name'], __DIR__ . '/uploads/' . $nombreSeguro);
    echo "Archivo subido correctamente";
}
?>