<?php
class LoginModelo {
    public $db;

    public function __construct() {
        $this->db = new PDO('mysql:host=localhost;dbname=miapp', 'usuario', 'clave', [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
    }

    public function verificarUsuario($usuario, $clave) {
        $sql = "SELECT id, usuario, clave_hash FROM usuarios WHERE usuario = :usuario LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':usuario', $usuario, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user && password_verify($clave, $user['clave_hash'])) {
            return $user;
        }
        return false;
    }
}
?>