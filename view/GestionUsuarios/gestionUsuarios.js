var tabla;

function init() {
    $('#usuario_form').on("submit", function(e){
        guardaryeditar(e);
    })
}

function guardaryeditar (e){
    e.preventDefault();
    var formData = new FormData($("#usuario_form")[0]);

    $.ajax({
        url: "../../controller/usuario.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(datos){
            console.log(datos)
            $('#usuario_form')[0].reset();
            $('#modalgestion').modal('hide')
            $('#usuario_data').DataTable().ajax.reload();

            swal({
                title: "SIT",
                text: "Completado.",
                type: "success",
                confirmButtonClass: "btn-success"
            });
        }
    })


}

$(document).ready(function () {
  //Imprimir tabla con la informacion almacenada de los usuarios.
  tabla = $("#usuario_data")
    .dataTable({
      aProcessing: true,
      aServerSide: true,
      dom: "Bfrtip",
      searching: true,
      lengthChange: false,
      colReorder: true,
      buttons: ["copyHtml5", "excelHtml5", "csvHtml5", "pdfHtml5"],
      ajax: {
        url: "../../controller/usuario.php?op=listar",
        type: "post",
        dataType: "json",
        error: function (e) {
          console.log(e.responseText);
        },
      },
      bDestroy: true,
      responsive: true,
      bInfo: true,
      iDisplayLength: 10,
      autoWidth: false,
      language: {
        sProcessing: "Procesando...",
        sLengthMenu: "Mostrar _MENU_ registros",
        sZeroRecords: "No se encontraron resultados",
        sEmptyTable: "Ningún dato disponible en esta tabla",
        sInfo: "Mostrando un total de _TOTAL_ registros",
        sInfoEmpty: "Mostrando un total de 0 registros",
        sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
        sInfoPostFix: "",
        sSearch: "Buscar:",
        sUrl: "",
        sInfoThousands: ",",
        sLoadingRecords: "Cargando...",
        oPaginate: {
          sFirst: "Primero",
          sLast: "Último",
          sNext: "Siguiente",
          sPrevious: "Anterior",
        },
        oAria: {
          sSortAscending:
            ": Activar para ordenar la columna de manera ascendente",
          sSortDescending:
            ": Activar para ordenar la columna de manera descendente",
        },
      },
    })
    .DataTable();
});

function editar(usu_id) {
    $('#mdltitulo').html('Editar Registro');

    $.post("../../controller/usuario.php?op=mostrar", { usu_id: usu_id }, function (data) {
            data= JSON.parse(data)
             
            $('#usu_id').val(data.usu_id)
            $('#usu_nombre').val(data.usu_nombre)
            $('#usu_apellido').val(data.usu_apellido)
            $('#usu_correo').val(data.usu_correo)
            $('#usu_password').val(data.usu_password)
            $('#usu_rol').val(data.usu_rol).trigger('change')
        });


    $('#modalgestion').modal('show');
}

function eliminar(usu_id) {
  swal(
    {
      title: "Consulta",
      text: "¿Está seguro de eliminar el Usuario?",
      type: "error",
      showCancelButton: true,
      confirmButtonClass: "btn-danger",
      confirmButtonText: "Si",
      cancelButtonText: "No",
      closeOnConfirm: false,
    },
    function (isConfirm) {
      if (isConfirm) {
        $.post(
          "../../controller/usuario.php?op=eliminar",
          { usu_id: usu_id },
          function (data) {}
        );

        //Refrescar la tabla despues de la eliminacion
        $("#usuario_data").DataTable().ajax.reload();

        swal({
          title: "SIT",
          text: "Usuario eliminado correctamente",
          type: "success",
          confirmButtonClass: "btn-success",
        });
      }
    }
  );
}

$(document).on("click", "#btnnuevo", function () {
    $('#mdltitulo').html('Nuevo Registro');
    $('#usuario_form')[0].reset();
    $('#modalgestion').modal('show');
});

init();
