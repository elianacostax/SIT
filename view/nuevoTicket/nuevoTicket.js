



//Ejecutar la funcion de summernote para la descripcion del ticktet.
$(document).ready(function() {
    $('#tick_descrip').summernote({
        height: 150,
        lang: "es-ES"
    });

    //Se importa el serivicio creado en el controller
    $.post("../../controller/categoria.php?op=combo",function(data, status){
         $('#cat_id').html(data); 
    });
});

//Funcion para enviar el nuevo ticket
function init(){
    $("#ticket_form").on("submit",function(e){
        guardaryeditar(e);	
    }); 
}

function guardaryeditar(e){
    e.preventDefault();
    var formData = new FormData($("#ticket_form")[0]);
    if ($('#tick_descrip').summernote('isEmpty') || $('#tick_titulo').val()==''){
        swal("Advertencia!", "Campos Vacios", "warning");
    }else{
        //Se realiza el envio de la informacion
    $.ajax({
        url: "../../controller/ticket.php?op=insert", 
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(datos){

            //Se resetea el formulario y se avisa que se creo correctamente.
            $('#tick_titulo').val('');
            $('#tick_descrip').summernote('reset');
            swal("Correcto!", "Registrado Correctamente", "success");
        }
        })
    } 

    
}

init();