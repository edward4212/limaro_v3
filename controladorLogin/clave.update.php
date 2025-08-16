<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        http_response_code(403);
        exit('CSRF token inválido.');
    }
    include_once "../entidadLogin/login.entidad.php";
    include_once "../modeloLogin/login.modelo.php";

    $usuario = filter_input(INPUT_POST, 'txtUsuarioAct', FILTER_SANITIZE_STRING);
    $clave = filter_input(INPUT_POST, 'txtClaveAct', FILTER_SANITIZE_STRING);

    $loginE = new \entidad\Login();
    $loginE->setUsuario($usuario);
    $loginE->setClave($clave);

    $loginM = new \modelo\Login($loginE);
    $resultado = $loginM->newpass();

    unset($loginE);
    unset($loginM);

    echo json_encode($resultado);
}
?>