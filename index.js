
function init(){
   
}

$(document).ready(function() {
 
});

$(document).on("click", "#btnsoporte", function(){

    if ($('#usu_rol').val()== 1) {
        $('#lbltitulo').html("Acceso Soporte");
        $('#btnsoporte').html("Acceso Usuario");
        $('#usu_rol').val(2);
        $("#imgtipo").attr("src","public/img/2.png");
    }else{
        $('#lbltitulo').html("Acceso Usuario");
        $('#btnsoporte').html("Acceso Soporte");
        $('#usu_rol').val(1);
        $("#imgtipo").attr("src","public/img/1.png");
    }
})

init();