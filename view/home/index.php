<!-- Validacion de incio de sesion de un usuario -->
<?php
  require_once("../../config/conexion.php"); 
  if(isset($_SESSION["usu_id"])){
?>

<!DOCTYPE html>
<html>
<?php require_once("../mainHead/head.php"); ?>
<title>SIT - Inicio</title>
</head>

<body class="with-side-menu">
    <!-- importar header -->
    <?php require_once("../mainHeader/header.php"); ?>
    <div class="mobile-menu-left-overlay"></div>
    <!-- importar barra de navegacion -->
    <?php require_once("../mainNav/nav.php"); ?>


    <!-- Contenido -->
    <div class="page-content">
        <div class="container-fluid">
            Blank page.
        </div>
    </div>

    <?php require_once("../mainJs/js.php"); ?>
    
    <script type="text/javascript" src="home.js"></script>
    
</body>

</html>
<?php
  } else {
    header("Location:".Conectar::ruta()."index.php");
  }
?>