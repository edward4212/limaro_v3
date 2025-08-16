<?php
namespace modelo;

include_once "../entidadLogin/login.entidad.php";
include_once "../entorno/conexionSingleton.php";

use PDO;

class Login {
    public $usuario;
    public $clave;
    public $conexion;

    public function __construct(\entidad\Login $loginE) {
        $this->usuario = $loginE->getUsuario();
        $this->clave = $loginE->getClave();
        $this->conexion = \Conexion::singleton();
    }

    public function read() {
        try {
            $sql = "SELECT
                us.id_usuario,
                us.usuario,
                us.estado as estadoUsuario,
                rol.id_rol,
                rol.rol,
                rol.estado,
                emp.id_empleado,
                emp.nombre_completo,
                emp.correo_empleado,
                emp.img_empleado,
                car.cargo,
                car.id_cargo,
                car.manual_funciones,
                ems.nombre_empresa,
                ems.logo
            FROM usuario AS us
                INNER JOIN rol AS rol ON us.id_rol = rol.id_rol
                INNER JOIN empleado AS emp ON us.id_empleado = emp.id_empleado
                INNER JOIN cargo AS car ON emp.id_cargo = car.id_cargo
                INNER JOIN empresa AS ems ON emp.id_empresa = ems.id_empresa
            WHERE us.usuario = :usuario AND us.clave = AES_ENCRYPT(:clave,'kddbjw8b3d')";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':usuario', $this->usuario);
            $stmt->bindParam(':clave', $this->clave);
            $stmt->execute();
            $retorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            $retorno = $e->getMessage();
        }
        return $retorno;
    }

    public function newpass() {
        try {
            $sql = "UPDATE usuario SET clave = AES_ENCRYPT(:clave,'kddbjw8b3d'), estado='ACTIVO'
                    WHERE usuario = :usuario AND estado = 'CREADO'";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':clave', $this->clave);
            $stmt->bindParam(':usuario', $this->usuario);
            $stmt->execute();
            $retorno = $stmt->rowCount();
        } catch (\Exception $e) {
            $retorno = $e->getMessage();
        }
        return $retorno;
    }
}
?>