/*=============================================
Mostrar Formulario Registro Perfil
=============================================*/
$("#registrarPerfil").click(function () {

    $("#formularioPerfil").toggle("fast");

});

//para poder subir una foto ya que en el form, el input de la foto no tiene name ni es requerido, entonces si cambia, le agrego el atributo name con el valor nueva imagen

$("#subirFotoPerfil").change(function () {

    $("#subirFotoPerfil").attr("name", "nuevaImagen");

});
/*=============================================
Mostrar Formulario Editar Perfil
=============================================*/
$("#btnEditarPerfil").click(function () {

    $("#editarPerfil").hide("fast");
    $("#formEditarPerfil").show("fast");

});

$("#cambiarFotoPerfil").change(function () {

    $("#cambiarFotoPerfil").attr("name", "editarImagen")

});