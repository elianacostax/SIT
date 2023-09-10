<!-- Validacion de incio de sesion de un usuario -->
<?php
require_once("../../config/conexion.php");
if (isset($_SESSION["usu_id"])) {
?>

  <!DOCTYPE html>
  <html>
  <?php require_once("../mainHead/head.php"); ?>
  <title>SIT - Gestion usuarios</title>
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
        <header class="section-header">
          <div class="tbl">
            <div class="tbl-row">
              <div class="tbl-cell">
                <h3>Gestion usuarios</h3>
                <ol class="breadcrumb breadcrumb-simple">
                  <li><a href="#">Inicio</a></li>
                  <li class="active">Gestion usuarios</li>
                </ol>
              </div>
            </div>
          </div>
        </header>

        <div class="box-typical box-typical-padding">
        <button type="button" id="btnnuevo" class="btn btn-inline btn-primary">Nuevo Registro</button>
          <table id="usuario_data" class="table table-bordered table-striped table-vcenter js-dataTable-full">
            <thead>
              <tr>
                <th style="width: 10%;">Nombre</th>
                <th style="width: 10%;">Apellido</th>
                <th class="d-none d-sm-table-cell" style="width: 40%;">Correo</th>
                <th class="d-none d-sm-table-cell" style="width: 10%;">Rol</th>
                <th class="d-none d-sm-table-cell" style="width: 5%;"></th>
                <th class="text-center" style="width: 5%;"></th>
              </tr>
            </thead>
            <tbody>

            </tbody>
          </table>

        </div>

      </div>
    </div>

    <?php require_once("modalgestion.php");?>

    <?php require_once("../mainJs/js.php"); ?>

    <script type="text/javascript" src="gestionUsuarios.js"></script>
  </body>

  </html>
<?php
} else {
  header("Location:" . Conectar::ruta() . "index.php");
}
?>