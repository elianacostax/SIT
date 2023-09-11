<!-- Validacion de incio de sesion de un usuario -->
<?php
require_once("../../config/conexion.php");
if (isset($_SESSION["usu_id"])) {
?>

  <!DOCTYPE html>
  <html>
  <?php require_once("../mainHead/head.php"); ?>
  <title>SIT - Consultar ticket</title>
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
                <h3>Consultar Ticket</h3>
                <ol class="breadcrumb breadcrumb-simple">
                  <li><a href="#">Inicio</a></li>
                  <li class="active">Consultar ticket</li>
                </ol>
              </div>
            </div>
          </div>
        </header>

        <div class="box-typical box-typical-padding">
          <table id="ticket_data" class="table table-bordered table-striped table-vcenter js-dataTable-full">
            <thead>
              <tr>
                <th style="width: 5%;">Nro.Ticket</th>
                <th style="width: 15%;">Categoria</th>
                <th class="d-none d-sm-table-cell" style="width: 20%;">Titulo</th>
                <th class="d-none d-sm-table-cell" style="width: 5%;">Estado</th>
                <th class="d-none d-sm-table-cell" style="width: 10%;">Fecha Creación</th>
                <th class="d-none d-sm-table-cell" style="width: 10%;">Fecha Asignación</th>
                <th class="d-none d-sm-table-cell" style="width: 10%;">Tecnico Asignado</th>
                <th class="text-center" style="width: 5%;"></th>
              </tr>
            </thead>
            <tbody>

            </tbody>
          </table>

        </div>

      </div>
    </div>

    <?php require_once("modalAsignar.php"); ?>
    <?php require_once("../mainJs/js.php"); ?>

    <script type="text/javascript" src="consultarTicket.js"></script>
  </body>

  </html>
<?php
} else {
  header("Location:".Conectar::ruta()."index.php");
}
?>