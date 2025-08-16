<?php
session_start();
require_once './lib/csrf.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ./login/login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || !verifyCsrfToken($_POST['csrf_token'])) {
        die('CSRF token inválido.');
    }

    if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['archivo']['tmp_name'];
        $fileName = basename($_FILES['archivo']['name']);
        $fileSize = $_FILES['archivo']['size'];
        $fileType = mime_content_type($fileTmpPath);

        // Validaciones de tipo y tamaño
        $allowedTypes = ['image/jpeg', 'image/png', 'application/pdf'];
        $maxSize = 2 * 1024 * 1024; // 2MB
        if (!in_array($fileType, $allowedTypes)) {
            $error = 'Tipo de archivo no permitido.';
        } elseif ($fileSize > $maxSize) {
            $error = 'Tamaño de archivo excede el límite permitido.';
        } else {
            // Nombre único y validación de ruta
            $newFileName = uniqid('file_', true) . '_' . preg_replace('/[^a-zA-Z0-9\._-]/', '', $fileName);
            $uploadFileDir = './uploads/';
            $destPath = $uploadFileDir . $newFileName;

            if (move_uploaded_file($fileTmpPath, $destPath)) {
                $mensaje = 'Archivo subido correctamente.';
            } else {
                $error = 'Error al subir el archivo.';
            }
        }
    } else {
        $error = 'No se seleccionó archivo o hubo un error.';
    }
}
$csrf_token = generateCsrfToken();
?>
<form method="POST" enctype="multipart/form-data">
    <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
    <input type="file" name="archivo" required>
    <button type="submit">Subir archivo</button>
    <?php if (isset($error)) echo "<p>$error</p>"; ?>
    <?php if (isset($mensaje)) echo "<p>$mensaje</p>"; ?>
</form>