
<!-- Funcion para cerrar sesión -->
<?php
    require_once("../../config/conexion.php");
    session_destroy();
    header("Location:".Conectar::ruta()."index.php");
    exit();
?>