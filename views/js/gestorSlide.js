/*=============================================
Área de arrastre de imágenes
=============================================*/
// me taigo el ID de la pagina slide.php
// console.log($("#columnasSlide").html());
// pregunta si en este div hay alguna informacion, si no la hay, se le agrega una altura de 100px, sino se le agrega una altura automatica
if ($("#columnasSlide").html() == 0) {

    $("#columnasSlide").css({ "height": "100px" });

} else {

    $("#columnasSlide").css({ "height": "auto" });

}

/**=============FIN AREA ARRASTE============= */

/*=============================================
Área de SUBIDA imágenes
=============================================*/
// con la funcion dragover puedo hacer resaltar una seccion dntro de una pagina y con las funciones preventDefault y stopPropagation puedo detener los eventos por defectos como por emjemplo abrir la imagen que subo en una pestaña nueva
$("#columnasSlide").on("dragover", function (e) {

    e.preventDefault();
    e.stopPropagation();
    // al detener estos eventos, arrraastro la imagen sobre la seccion y le indico que cambie el fondo por la imagen del url
    $("#columnasSlide").css({ "background": "url(views/images/pattern.jpg)" })

})
/**=============FIN AREA SUBIDA============= */


/*=============================================
Área de SOLTAR imágenes
=============================================*/
// ahora con la funcion drop puedo capturar esa imagen soltada sobre la seccion que me estoy trayendo
$("#columnasSlide").on("drop", function (e) {

    e.preventDefault();
    e.stopPropagation();
    // para visualizar que estoy aceptando la imagen, cambio el fondod a blanco
    $("#columnasSlide").css({ "background": "white" })
    // con esta funcion originalEvent.dataTransfer.files guardo la imagen en una variable
    var archivo = e.originalEvent.dataTransfer.files;

    // console.log(archivo);
    // sabiendo que esta en el indice 0, puedo guardarla en una variable para luego trabajar sobre ella
    var imagen = archivo[0];

    // validar tamaño  de la imagen
    var imagenSize = imagen.size;
    // console.log(imagenSize);

    if (Number(imagenSize) > 2000000) {

        // si es mayor, llamo a una clase de bootstrap y muestro el warning
        $("#columnasSlide").before('<div class="alert alert-danger alerta text-center">El archivo excede el peso permitido, 200kb</div>')

    } else {
        // cerrar la clase alerta que creé en el div de arriba
        $(".alerta").remove();

    }
    // validar tipo de la imagen
    var imagenType = imagen.type;

    if (imagenType == "image/jpeg" || imagenType == "image/png") {

        $(".alerta").remove();

    } else {

        $("#columnasSlide").before('<div class="alert alert-danger alerta text-center">El archivo debe ser formato jpg o png</div>')

    }

    // Subir imagen al servidor
    if (Number(imagenSize) < 2000000 && imagenType == "image/jpeg" || imagenType == "image/png") {

        var datos = new FormData();

        datos.append("imagen", imagen);

        $.ajax({
            url: "views/ajax/gestorSlide.php",
            method: "POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            beforeSend: function () { //mientras se carga la imagen

                $("#columnasSlide").before('<img src="views/images/status.gif" id="status">');

            },//recibe la respuesta del ajax, del archivo views/ajax/gestorSlide.php que a su vez llama al controlador y esta a su vez llama al modelo
            success: function (respuesta) {

                $("#status").remove(); // para quitar el icono de carga..
                // respuesta viene de alla del controlador
                if (respuesta == 0) {

                    console.log('respuesta negativa', respuesta);
                    // esto significa que el peso el menor al requerido por lo tanto se manda un mensaje despues del LI con id columnasSlide
                    $("#columnasSlide").before('<div class="alert alert-danger alerta text-center">La imagen es inferior a 1600px * 600px</div>')

                } else {
                    // al columnasSlide se le asigna el alto automatico para que tome el alto de la immagen
                    $("#columnasSlide").css({ "height": "auto" });

                    console.log('respuesta', respuesta);
                    // coloque en el SRC la variable ruta pero como vivene en n JSON puedo llamar el indice ruta
                    // como la ruta trae enlaces ../../ que me sacan dela carpeta index, con la funcion SLICE() yo puedo borrar esos caracteres que no necesito, en este caso con 6
                    $("#columnasSlide").append('<li class="bloqueSlide"><span class="fa fa-times eliminarSlide"></span><img src="' + respuesta["ruta"].slice(6) + '" class="handleImg"></li>');

                    $("#ordenarTextSlide").append('<li><span class="fa fa-pencil" style="background:blue"></span><img src="' + respuesta["ruta"].slice(6) + '" style="float:left; margin-bottom:10px" width="80%"><h1>' + respuesta["titulo"] + '</h1><p>' + respuesta["descripcion"] + '</p></li>');

                    // Window.location.reload(); de esta forma podiramos recargar la imagen cuando se suba la imagen con ajax para qque pueda servir el boton de eliminar pro es my feo para el usuario notar que se recarga. por eso vamos a usar otra herramienta. ALERTAS SUAVES.

                    swal({
                        title: "¡OK!",
                        text: "¡La imagen se subió correctamente!",
                        type: "success",
                        confirmButtonText: "Cerrar",
                        closeOnConfirm: false
                        },
                        function (isConfirm) {
                            if (isConfirm) {
                                window.location = "slide";
                            }
                         });
                }
            }
        });
    }
})

/**=============FIN AREA SOLTAR============= */

/**===============ELIMINAR ITEM SLIDE */

$(".eliminarSlide").click(function () {

    if($(".eliminarSlide").length == 1){

        $("#columnasSlide").css({ "height": "100px" });
    }

    // Capturame el ID que tiene tu papa. estamos trabajando en el SPAN pero el ID esta en el LI, por eso lo hacemos de esta forma

    idSlide = $(this).parent().attr("id");

    // selecciono la clase ruta que le agregue al span
    rutaSlide = $(this).attr("ruta");
    console.log(rutaSlide);


    $(this).parent().remove();
    $("#item" + idSlide).remove();

    var borrarItem = new FormData();
    borrarItem.append("idSlide", idSlide);
    borrarItem.append("rutaSlide", rutaSlide);

    $.ajax({
        url: "views/ajax/gestorSlide.php",
        method: "POST",
        data: borrarItem,
        cache: false,
        contentType: false,
        processData: false,
        success: function (respuesta) {
            console.log(respuesta);
            swal({
                title: "¡OK!",
                text: "¡Se ha borrado correctamente!",
                type: "success",
                confirmButtonText: "Cerrar",
                closeOnConfirm: false
            },
                function (isConfirm) {
                    if (isConfirm) {
                        window.location = "slide";
                    }
                });
        }

    })
})


/**===========FIn ELIMINAR ITEN SLIDE */

/**======================EDITAR ITEM SLIDE =====*/

$(".editarSlide").click(function(){

    // al hacer click al cuadrito de editar, estoy guardando en la variable IDSLIDE el valor del atributo ID del padre que tiene contenido el SPAN. sabemos que EDITARSLIDE es una CLASE de la etiqueta SPAN y su PADRE es el LI. este LI ya tiene un ID que definimos con el PREFIJO ITEM mas el ID que trajimos de la base de datos. ejemplo item1, item2 y asi.
    idSlide = $(this).parent().attr("id"); 
    // a lo que le estoy dando click, vayase a donde su papa y por favor papa, busqueme a un hijo que tenga una imagen y de esa imagen captureme el atributo SRC. EN ESTE CASO, THIS ES EL SPAN
    rutaImagen = $(this).parent().children("img").attr("src");
    rutaTitulo = $(this).parent().children("h1").html();
    rutaDescripcion = $(this).parent().children("p").html();
    // luego que tenemos el ID, le decimos al papa que cambie su HTML por este que le estamos dando aca!!!

    $(this).parent().html('<img src="'+rutaImagen+'" class="img-thumbnail"><input type="text" class="form-control" id="enviarTitulo" placeholder="Título" value="'+rutaTitulo+'"><textarea row="5" class="form-control" id="enviarDescripcion" placeholder="Descripción">'+rutaDescripcion+'</textarea><button class="btn btn-info pull-right" style="margin:10px" id="guardar'+idSlide+'">Guardar</button>');
    // en estas lineas de arriba, estoy  preparando el LI donde puedo editar. las variables JS que estoy agregando son las que traigo de la base de datos para que se muestren en el LI y efectivamente poder eitarlo.


    // console.log(idSlide);
	$("#guardar"+idSlide).click(function(){
       
        // aqui con el slice le quito 4 caracteres al ID porque anteriormente para diferenciarlo le agregue el prefijo item.
        enviarId = idSlide.slice(4);
        // tomo el value del input  donde esta l titulo y lo guardo en la variable enviarTitulo
        enviarTitulo = $("#enviarTitulo").val();
        // lo mismo para la descripcion.
        enviarDescripcion = $("#enviarDescripcion").val();

        // creo una instancia de FormData para el ajax.
        var actualizarSlide = new FormData();

        // cargo los datos que voy a mandar por ajax

        actualizarSlide.append("enviarId", enviarId);
        actualizarSlide.append("enviarTitulo", enviarTitulo);
        actualizarSlide.append("enviarDescripcion", enviarDescripcion);


        $.ajax({
            url: "views/ajax/gestorSlide.php",
            method: "POST",
            data: actualizarSlide,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json", //si no recibo DATATYPE : "JSON" no me da error pero aparece indefinido, solo se arregla al actualizar la pagina
            success:function(respuesta){

                // console.log(respuesta["titulo"], respuesta["descripcion"]);
                $("#guardar"+idSlide).parent().html('<span class="fa fa-pencil editarSlide" style="background:blue"></span><img src="'+rutaImagen+'" style="float:left; margin-bottom:10px" width="80%"><h1>'+respuesta["titulo"]+'</h1><p>'+respuesta["descripcion"]+'</p>');

				swal({
                    title: "¡OK!",
                    text: "¡Se han guardado los cambios correctamente!",
                    type: "success",
                    confirmButtonText: "Cerrar",
                    closeOnConfirm: false
                    },
                    function(isConfirm){
                        if (isConfirm){
                            window.location = "slide";
                        }
                    });
                
            }

        });
    })
})

/**====================== FIN EDITAR ITEM SLIDE */

/**============ORDENAR ITEM SLIDE =======================*/
var almacenarOrdenId = new Array();
var ordenItem = new Array();
$("#ordenarSlide").click(function(){

    $("#ordenarSlide").hide();// oculto el boton de ordenar
    $("#guardarSlide").show();//hago aparecer el boton de guardar

    $("#columnasSlide").css({"cursor":"move"}); //modifico el cursor a mover cuando pase sobre columnasSlide, o sea, donde subo las imagenes

    $("#columnasSlide span").hide(); // oculto el span, o sea, el boton de borrar

    $("#columnasSlide").sortable({ //con la libreria sortable puedo mover las imagenes.
        revert:true, // para que se devuelva si suelto la imagen en otro lado que no sea el columnasSlide, o sea, donde subo las imagenes
        connectWith:".bloqueSlide", //para conectar los bloques de las imagenes. estas clases las tienen las LI donde estan las imagenes
        handle:".handleImg", //clase de las imagenes.
        stop:function(event){ // no entendi muy bien esta funcion pero mas o menos va asi.
            for (var i = 0; i < $("#columnasSlide li").length; i++) { //recorro las columnasSlide li para ir almacenando los ID de las imagenes.
                almacenarOrdenId[i] = event.target.children[i].id;//con esta sentencia recojo los ID y los guardo
                console.log("imagen",almacenarOrdenId[i]);
                ordenItem[i] = i+1; //para llevar el orden nuevo.
                console.log("orden",ordenItem[i]);
            }
        }
    });
});


$("#guardarSlide").click(function(){ // darle click sobre el boton,

    $("#ordenarSlide").show();//muestro el de ordenar
    $("#guardarSlide").hide();// y oculto el de guardar.

    for (var i = 0; i < $("#columnasSlide li").length; i++) {//recorro las columnas para ajecutar el ajax.

        var actualizarOrden = new FormData();

        actualizarOrden.append("actualizarOrdenSlide", almacenarOrdenId[i]);//agrego las variables
        actualizarOrden.append("actualizarOrdenItem", ordenItem[i]);

        $.ajax({
            url: "views/ajax/gestorSlide.php",
            method: "POST",
            data: actualizarOrden,// y las mando por ajax.
            cache: false,
            contentType: false,
            processData: false,
            success:function(respuesta){   //recibo la respuesta de lo que se fue al ajax que se fue al controlador, que se fue al modelo y luego a la base de datos que asi mismo volvio a la base de datos para traer el nuevo orden, paso por el controlador, por el ajax y llego nuevamente hasta aqui. en el controlador modifique el LI aqui solo lo recibo y lo mando al textoSlide UL.             

                $("#textoSlide ul").html(respuesta);

                swal({
                    title: "¡OK!",
                    text: "¡El orden se ha actualizado correctamente!",
                    type: "success",
                    confirmButtonText: "Cerrar",
                    closeOnConfirm: false
                    },
                    function(isConfirm){
                        if (isConfirm){
                            window.location = "slide";
                        }
                    });

            }
        });
    }
});


/**============ FIN ORDENAR ITEM SLIDE ==============0===*/