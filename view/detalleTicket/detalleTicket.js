function init() {}

$(document).ready(function () {

    var tick_id = getUrlParameter('ID');
     //Añadir los valores dinamicamente a los campos
     listarDetalle(tick_id);

   
   

    //Inicializar textarea con la libreria summernote
    $('#tickd_descrip').summernote({
        height: 300,
        lang: "es-ES"
    });

    $('#tickd_descripusu').summernote({
        height: 300,
        lang: "es-ES"
    });
    //Deshabilitar textarea para que solo sea de visualizacion
    $('#tickd_descripusu').summernote('disable');

    //Tomar los botones de enviar y cerrar para añadirle funcionalidad
    $(document).on("click", '#btnenviar', function(){
        var tick_id = getUrlParameter('ID');
        var usu_id = $('#user_idx').val();
        var tickd_descrip = $('#tickd_descrip').val();

        if ($('#tickd_descrip').summernote('isEmpty')){
            swal("Advertencia!", "Hace falta descripción", "warning");
        }else{
            $.post("../../controller/ticket.php?op=insertdetalle", { tick_id : tick_id, usu_id:usu_id, tickd_descrip:tickd_descrip }, function(data){
                listarDetalle(tick_id);
                $('#tickd_descrip').summernote('reset');
                swal("Correcto!", "Registrado Correctamente", "success");
            }); 
        }
    });

    $(document).on("click", '#btncerrarticket', function(){
        swal({
            title: "Consulta",
            text: "¿Está seguro de cerrar el ticket?",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-warning",
            confirmButtonText: "Si",
            cancelButtonText: "No",
            closeOnConfirm: false,
        },
        function(isConfirm) {
            if (isConfirm) {
                var tick_id = getUrlParameter('ID');
                var usu_id = $('#user_idx').val();

                $.post("../../controller/ticket.php?op=update", { tick_id : tick_id, usu_id:usu_id }, function(data){
                  
                });

                listarDetalle(tick_id);

                swal({
                    title: "SIT",
                    text: "Ticket cerrado correctamente",
                    type: "success",
                    confirmButtonClass: "btn-success"
                });
            } 
        });   
    });

    function listarDetalle(tick_id){
        $.post("../../controller/ticket.php?op=listardetalle", { tick_id : tick_id }, function(data){
            $('#lbldetalle').html(data);
    });

    $.post("../../controller/ticket.php?op=mostrar", { tick_id : tick_id }, function(data){
        data = JSON.parse(data);
        $('#lblestado').html(data.tick_est);
        $('#lblnomusuario').html(data.usu_nombre + ' ' + data.usu_apellido);
        $('#lblfechcrea').html(data.tick_fechcrea);
        $('#lblnomidticket').html('Detalle Ticket - ' + data.tick_id);
        $('#cat_nom').val(data.cat_nombre);
        $('#tick_titulo').val(data.tick_titulo);       
        $('#tickd_descripusu').summernote('code', data.tick_descrip);

        if (data.tick_est_texto == "Cerrado") {
            $('#pnldetalle').hide();
        }
       

    });

    }

});

var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : sParameterName[1];
        }
    }
};


init();
