
function init(){
   
}

$(document).ready(function() {
 
});

$(document).on("click", "#btnsoporte", function(){

    if ($('#usu_rol').val()== 1) {
        $('#lbltitulo').html("Acceso Soporte");
        $('#btnsoporte').html("Acceso Usuario");
        $('#usu_rol').val(2);
       // $("#imgtipo").attr("src","public/2.jpg");
    }else{
        $('#lbltitulo').html("Acceso Usuario");
        $('#btnsoporte').html("Acceso Soporte");
        $('#usu_rol').val(1);
       // $("#imgtipo").attr("src","public/1.jpg");
    }
})

init();