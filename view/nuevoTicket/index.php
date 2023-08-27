<!-- Validacion de incio de sesion de un usuario -->
<?php
require_once("../../config/conexion.php");
if (isset($_SESSION["usu_id"])) {
?>

  <!DOCTYPE html>
  <html>
  <?php require_once("../mainHead/head.php"); ?>
  <title>SIT - Nuevo ticket</title>
  </head>

  <body class="with-side-menu">
    <!-- importar header -->
    <?php require_once("../mainHeader/header.php"); ?>
    <div class="mobile-menu-left-overlay"></div>
    <!-- importar barra de navegacion -->
    <?php require_once("../mainNav/nav.php"); ?>


    <!-- Contenido -->
    <div class="page-content">

      <!-- Componente para crear un nuevo ticket. -->
      <div class="container-fluid">
        <header class="section-header">
          <div class="tbl">
            <div class="tbl-row">
              <div class="tbl-cell">
                <h3>Nuevo Ticket</h3>
                <ol class="breadcrumb breadcrumb-simple">
                  <li><a href="#">Inicio</a></li>
                  <li class="active">Nuevo ticket</li>
                </ol>
              </div>
            </div>
          </div>
        </header>

        <div class="box-typical box-typical-padding">
          <p>En esta ventana podrá crear nuevos reportes.</p>

          <div class="row">
            <form  method="post" id="ticket_form" >

            <input type="hidden" id="usu_id" name="usu_id" value="<?php echo $_SESSION["usu_id"] ?>">

              <div class="col-lg-6">
                <fieldset class="form-group">
                  <label class="form-label semibold" for="cat_id">Categoria</label>
                  <select id="cat_id" name="cat_id" class="form-control">

                  </select>
                </fieldset>
              </div>


              <div class="col-lg-6">
                <fieldset class="form-group">
                  <label class="form-label semibold" for="tick_titulo">Titulo</label>
                  <input type="text" class="form-control" id="tick_titulo" name="tick_titulo" placeholder="Ingrese Titulo">
                </fieldset>
              </div>


              <div class="col-lg-12">
                <fieldset class="form-group">
                  <label class="form-label semibold" for="tick_descrip">Descripción</label>

                  <div class="summernote-theme-1">
                    <textarea class="summernote" id="tick_descrip" name="tick_descrip"></textarea>
                  </div>
                </fieldset>


              </div>
              <div class="col-lg-12">
                <button type="submit" name="action" value="add" class="btn btn-rounded btn-inline btn-primary">Guardar</button>
              </div>

          </div>
          </form>

        </div>
      </div>

      <?php require_once("../mainJs/js.php"); ?>

      <script src="./nuevoTicket.js"> </script>

  </body>

  </html>
<?php
} else {
  header("Location:" . Conectar::ruta() . "index.php");
}
?>