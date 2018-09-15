/**AGREGAR ARTICULOS======================= */

$("#btnAgregarArticulo").click(function(){
    //DOS. hacemos que aparezca o desaparezca el DIV contenerdor de los articulos en 400ms. si esta oculto lo muestra y si esta mostrado lo oclta
    $("#agregarArtículo").toggle(400);
});

/**FIN AGREGAR ARTICULO==================== */

/**SUBIR IMAGEN A TRAVES DEL INPUT========= */

// var imagen = ""; como no voy a usar estas variables fuera de la function change, no necesito crear las variables de forma global.

$("#subirFoto").change(function(){

    // cuando se suba el arcivo de la variable imagen, almacenemos las caracteriasticas de ese archivo. eso me lo permite .files en la posicion0.
    imagen = this.files[0];
    
    // ya obteniendo estas propiedades, puedo validar el tamaño de las imagenes.
    imagenSize = imagen.size;

    if (Number(imagenSize) > 2000000){
        // si la imagen que estoy subiendo es mas grande de lo que estoy permitiendo, que me aparezca un alerta arriba del DIV donde yo recibo las imagenes cuyo ID es arrastreImagenArticulo. 
        $("#arrastreImagenArticulo").before('<div class="alert alert-warning alerta text-center">El archivo excede el peso permitido, 200kb</div>');
    }else{

        // sino, remuevo esa alerta. lo elimino una vez que ya hayan cargado una foto con tamaño permitido.
        $(".alerta").remove();

    }

    // ahora validamos el tipo de imagen
    imagenType = imagen.type;
    
    if (imagenType == "image/jpeg" || imagenType == "image/png"){
        // por si anteriormente se equivoco antes de coincidir con esta condicion
        $(".alerta").remove();
    }else{
        $("#arrastreImagenArticulo").before('<div class="alert alert-warning alerta text-center">El archivo debe ser formato PEG o PNG</div>');
    }

    /*=============================================
	Mostrar imagen con AJAX       
	=============================================*/
    if (Number(imagenSize) < 2000000 && imagenType == "image/jpeg" || imagenType == "image/png"){

        var datos = new FormData();

        datos.append("imagen", imagen);

        $.ajax({
            url: "views/ajax/gestorArticulos.php",
            method: "POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function () {
                // gif de carga
                $("#arrastreImagenArticulo").before('<img src="views/images/status.gif" id="status">');
            },
            success: function (respuesta) {
                $("#status").remove();

                if (respuesta == 0) {

                    $("#arrastreImagenArticulo").before('<div class="alert alert-warning alerta text-center">La imagen es inferior a 800px * 400px</div>')

                } else {

                    $("#arrastreImagenArticulo").html('<div id="imagenArticulo"><img src="' + respuesta.slice(6) + '" class="img-thumbnail"></div>');

                }                
            }
        });
    }    
});

/** FIN SUBIR IMAGEN A TRAVES DEL INPUT========= */

/**EITAR ARTICULO======================== */

// cuando le doy click al boton editar articulo me ejecutara stas funciones.
$(".editarArticulo").click(function(){
    // me toma el id del articulo al cual le doyy a editar al igual que tomo la ruta de la imagen, el titulo, la intro y el contenido
    idArticulo = $(this).parent().parent().attr("id");
    rutaImagen = $("#" + idArticulo).children("img").attr("src");
    titulo = $("#" + idArticulo).children("h1").html();
    introduccion = $("#" + idArticulo).children("p").html();    
    contenido = $("#" + idArticulo).children("input").val();
    
    //asi mismo cuando le doy click a editar, el html me cambia por lo que le estoy indicando aca y en ese html tomo lo traido en la base de dato. lo qu ya estaba en la base datos al momento de crear o guardar e articulo.
    
    // en este mismo codigo html se le agrega unos names que voy a utulizar para enviarlos a la base de datos con ajax una vez haya modificado o editado.
    $("#"+idArticulo).html('<form method="post" enctype="multipart/form-data"><span><input style="width:10%; padding:5px 0; margin-top:4px" type="submit" class="btn btn-primary pull-right" value="Guardar"></span><div id="editarImagen"><input style="display:none" type="file" id="subirNuevaFoto" class="btn btn-default"><div id="nuevaFoto"><span class="fa fa-times cambiarImagen"></span><img src="'+rutaImagen+'" class="img-thumbnail"></div></div><input type="text" value="'+titulo+'" name="editarTitulo"><textarea cols="30" rows="5" name="editarIntroduccion">'+introduccion+'</textarea><textarea name="editarContenido" id="editarContenido" cols="30" rows="10">'+contenido+'</textarea><input type="hidden" value="'+idArticulo+'" name="id"><input type="hidden" value="'+rutaImagen+'" name="fotoAntigua"><hr></form>');

    $(".cambiarImagen").click(function(){

        // al hacer click al iconito de eliminar la imagen, esconde dicho iconito y muestra el input que estaba oculto de tipo file que sirve para subir imagenes, se modifica su css y vacia el lugar donde estaba la imagen anterior. en este caso las etiquetas SPAN Y IMG..
        $(this).hide();

        $("#subirNuevaFoto").show();//esconde dicho iconito
        $("#subirNuevaFoto").css({ "width": "88%" });//y muestra el input que estaba oculto de tipo file que sirve para subir imagenes
        $("#nuevaFoto").html(""); //vacio el DIV donde estaba la imagen  vieja para luego mostrar la nueva seleccionada
        $("#subirNuevaFoto").attr("name", "editarImagen");//cuando selecciono la imagen nueva es qque le asigno el atributo name y editarImagen

        // en el momoento que ocurra un cambio en el input, yo le asigno un nombre a esa etiqueta la cual sera la que usare. y le asigno el etributo required. coloco el name cuando haya el cambio en el input porque si se lo agrego en el html inicial y no uso el input, me lo enviara vacio.
        $("#subirNuevaFoto").attr("required", true);
        $("#subirNuevaFoto").change(function () {

            imagen = this.files[0];
            imagenSize = imagen.size;

            if (Number(imagenSize) > 2000000) {

                $("#editarImagen").before('<div class="alert alert-warning alerta text-center">El archivo excede el peso permitido, 200kb</div>')

            }else{

                $(".alerta").remove();

            }

            imagenType = imagen.type;

            if (imagenType == "image/jpeg" || imagenType == "image/png") {

                $(".alerta").remove();

            }else{

                $("#editarImagen").before('<div class="alert alert-warning alerta text-center">El archivo debe ser formato JPG o PNG</div>')

            }

            if (Number(imagenSize) < 2000000 && imagenType == "image/jpeg" || imagenType == "image/png") {

                var datos = new FormData();

                datos.append("imagen", imagen);

                $.ajax({
                    url: "views/ajax/gestorArticulos.php",
                    method: "POST",
                    data: datos,
                    cache: false,
                    contentType: false,
                    processData: false,
                    beforeSend: function () {

                        $("#nuevaFoto").html('<img src="views/images/status.gif" style="width:15%" id="status2">');

                    },
                    success: function (respuesta) {

                        $("#status2").remove();

                        if (respuesta == 0) {

                            $("#editarImagen").before('<div class="alert alert-warning alerta text-center">La imagen es inferior a 800px * 400px</div>')

                        }else{

                            $("#nuevaFoto").html('<img src="' + respuesta.slice(6) + '" class="img-thumbnail">');

                        }
                    }
                })
            }
        })
    });
});

/**ORDENAR ARTICULLOS =================================== */
var almacenarOrdenId = new Array();
var ordenItem = new Array();

$("#ordenarArticulos").click(function(){

    $("#ordenarArticulos").hide();
    $("#guardarOrdenArticulos").show();
    $("#editarArticulo").css({"cursor":"move"})
    $("#editarArticulo span i").hide();
    $("#editarArticulo button").hide();
    $("#editarArticulo img").hide();
    $("#editarArticulo p").hide();
    $("#editarArticulo hr").hide();
    $("#editarArticulo div").remove()
    $(".bloqueArticulo h1").css({ "font-size": "14px", "position": "absolute", "padding": "10px", "top": "-15px" })
    $(".bloqueArticulo").css({ "padding": "2px" })
    $("#editarArticulo span").html('<i class="glyphicon glyphicon-move" style="padding:8px"></i>')

    // para que se vaya hacia la parte de arriba de la pagina y lo haga en medio segundo (500ms)
    $("body, html").animate({

        scrollTop: $("body").offset().top

    }, 500)

    $("#editarArticulo").sortable({
        revert: true,//si se mueve un poquito o no se mueve, que se vaya a su posicion original
        connectWith: ".bloqueArticulo",//lo conectamos con cada uno de los LI, esta clase esta ddefinida en los LI del controlador
        handle: ".handleArticle",//lo agarraremos de la clase handleArticle, esto depende de donde querramos agarrarlo, en este caso lo estamos agarrand desde la bandita gris, la ccual es el span, por eso le colocamos esta clase al span del controlador. puede ser el nombre que uno quiera
        stop: function (event) {//esta funcion es la que nos va a terminar el evento

            for (var i = 0; i < $("#editarArticulo li").length; i++) {

                almacenarOrdenId[i] = event.target.children[i].id;//me toma el id de los editarArticulo li
                ordenItem[i] = i + 1;//me genera el nuevo orden..

            }
        }
    })

    $("#guardarOrdenArticulos").click(function () {

        $("#ordenarArticulos").show();
        $("#guardarOrdenArticulos").hide();

        for (var i = 0; i < $("#editarArticulo li").length; i++) {

            var actualizarOrden = new FormData();
            actualizarOrden.append("actualizarOrdenArticulos", almacenarOrdenId[i]);
            actualizarOrden.append("actualizarOrdenItem", ordenItem[i]);

            $.ajax({

                url: "views/ajax/gestorArticulos.php",
                method: "POST",
                data: actualizarOrden,
                cache: false,
                contentType: false,
                processData: false,
                success: function (respuesta) {

                    $("#editarArticulo").html(respuesta);//en la respuesta traigo los articulos con el nuevo orden y la version de la vista. el controlador se encargara de eso.

                    swal({
                        title: "¡OK!",
                        text: "¡El orden se ha actualizado correctamente!",
                        type: "success",
                        confirmButtonText: "Cerrar",
                        closeOnConfirm: false
                    },
                        function (isConfirm) {
                            if (isConfirm) {
                                window.location = "articulos";
                            }
                        });
                }
            })
        }
    })
})
