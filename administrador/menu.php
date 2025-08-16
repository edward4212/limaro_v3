<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/login.php");
    exit();
}
$logo = isset($_SESSION['logo']) ? htmlspecialchars($_SESSION['logo']) : 'default.png';
$usuario = isset($_SESSION['usuario']) ? htmlspecialchars($_SESSION['usuario']) : 'Administrador';
?>
<!-- Inicio Menu -->
<header class="navbar navbar-expand-lg navbar-light fixed-top border-bottom" style="background-color: #f8f9fa; top: 5px;">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <img src="../documentos/limaro/horizontal_on_white_by_logaster.png" alt="Limaro Logo" width="100" height="40" class="d-inline-block align-top">
            <img src="../documentos/empresa/logo/<?php echo $logo; ?>" alt="Company Logo" width="100" height="40" class="d-inline-block">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link text-primary" href="inicio.php"><i class="fas fa-home"></i> Inicio</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-primary" href="#" id="navbarDropdownDocs" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-indent"></i> Indice de Documentos
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownDocs">
                        <li><a class="dropdown-item text-primary" href="macroprocesos.php"><i class="fas fa-cogs"></i> Macroprocesos</a></li>
                        <li><a class="dropdown-item text-primary" href="procesos.php"><i class="fas fa-cog"></i> Procesos</a></li>
                        <li><a class="dropdown-item text-primary" href="documentos.php"><i class="fas fa-book"></i> Tipo de Documentos</a></li>
                        <li><a class="dropdown-item text-primary" href="registro.php"><i class="far fa-address-book"></i> Documentos Registrados</a></li>
                        <li><a class="dropdown-item text-primary" href="vigentes.php"><i class="fas fa-list"></i> Listado Maestro de Documentos</a></li>
                        <li><a class="dropdown-item text-primary" href="obsoletos.php"><i class="far fa-times-circle"></i> Listado Maestro de Documentos</a></li>
                        <li><a class="dropdown-item text-primary" href="versionamiento.php"><i class="far fa-plus-square"></i> Versionamiento</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-primary" href="#" id="navbarDropdownSolicitudes" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-th-list"></i> Solicitudes
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownSolicitudes">
                        <li class="dropdown-submenu">
                            <a class="dropdown-item dropdown-toggle text-primary" href="#"><i class="far fa-calendar-alt"></i> Gestion De Solicitudes</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item text-primary" href="solicitudes.php"><i class="far fa-calendar-check"></i> Solicitudes Radicadas</a></li>
                                <li><a class="dropdown-item text-primary" href="solicitudesAs.php"><i class="fas fa-calendar-alt"></i> Solicitudes</a></li>
                                <!-- Completa aquí el resto de enlaces de solicitudes según el menú original -->
                            </ul>
                        </li>
                    </ul>
                </li>
                <!-- Agrega más ítems según el menú original -->
            </ul>
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <span class="navbar-text text-info">Bienvenido, <?php echo $usuario; ?></span>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-danger" href="../controladorLogin/logout.php"><i class="fas fa-sign-out-alt"></i> Cerrar sesión</a>
                </li>
            </ul>
        </div>
    </div>
</header>
