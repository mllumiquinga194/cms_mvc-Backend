/*=============================================
Área de arrastre de videos
=============================================*/

if ($("#galeriaVideo").html() == 0) {

    $("#galeriaVideo").css({ "height": "100px" });

}

else {

    $("#galeriaVideo").css({ "height": "auto" });

}

/**SUBIR VIDEOS====================== */

$("#subirVideo").change(function(){

    video = this.files[0];

    videoSize = video.size;    

    if (Number(videoSize) > 50000000){

        $("#galeriaVideo").before('<div class="alert alert-warning alerta text-center">El archivo excede el peso permitido, 50Mb</div>');
    }else{

        $(".alerta").remove();
    }

    videoType = video.type;

    if (videoType == "video/mp4") {

        $(".alerta").remove();
    } else {

        $("#galeriaVideo").before('<div class="alert alert-warning alerta text-center">El archivo debe ser formato MP4</div>');
    }

    if (Number(videoSize) < 50000000 && videoType == "video/mp4") {

        var datos = new FormData();

        datos.append("video", video);

        $.ajax({

            url: "views/ajax/gestorVideos.php",
            method: "POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function () {
                // gif de carga
                $("#galeriaVideo").before('<img src="views/images/status.gif" id="status">');
            },
            success: function (respuesta) {
                console.log(respuesta);                

                $("#status").remove();

                $("#galeriaVideo").css({"height":"auto"});

                $("#galeriaVideo").append('<li><span class= "fa fa-times"></span><video controls><source src="'+respuesta.slice(6)+'" type="video/mp4"></video></li>');

                swal({
                    title: "¡OK!",
                    text: "¡El vídeo se subió correctamente!",
                    type: "success",
                    confirmButtonText: "Cerrar",
                    closeOnConfirm: false
                },
                    function (isConfirm) {
                        if (isConfirm) {
                            window.location = "videos";
                    }
                });
            }
        })
    }
})

/*=============================================
Eliminar Video
=============================================*/
    $(".eliminarVideo").click(function () {

        if ($(".eliminarVideo").length == 1) {

            $("#galeriaVideo").css({ "height": "100px" });

         }

    idVideo = $(this).parent().attr("id");
    rutaVideo = $(this).attr("ruta");

    $(this).parent().remove();    

    var borrarVideo = new FormData();
    
    borrarVideo.append("idVideo", idVideo);
    borrarVideo.append("rutaVideo", rutaVideo);
    
    $.ajax({
        url: "views/ajax/gestorVideos.php",
        method: "POST",
        data: borrarVideo,
        cache: false,
        contentType: false,
        processData: false,
        success: function (respuesta) {
            console.log(respuesta);
        }

    })
    
})

var almacenarOrdenId = new Array();
var ordenItem = new Array();

$("#ordenarVideo").click(function(){

    $("#ordenarVideo").hide();
    $("#guardarVideo").show();
    $("#galeriaVideo").css({ "cursor": "move" });
    $("#galeriaVideo span").hide();



    $("#galeriaVideo").sortable({
        revert: true,//si se mueve un poquito o no se mueve, que se vaya a su posicion original
        connectWith: ".bloqueVideo",//lo conectamos con cada uno de los LI, esta clase esta ddefinida en los LI del controlador
        handle: ".handleVideo",//lo agarraremos de la clase handleArticle, esto depende de donde querramos agarrarlo, en este caso lo estamos agarrand desde la bandita gris, la ccual es el span, por eso le colocamos esta clase al span del controlador. puede ser el nombre que uno quiera
        stop: function (event) {//esta funcion es la que nos va a terminar el evento

            for (var i = 0; i < $("#galeriaVideo li").length; i++) {

                almacenarOrdenId[i] = event.target.children[i].id;//me toma el id de los editarArticulo li
                ordenItem[i] = i + 1;//me genera el nuevo orden..   
            }
        }
    })

    $("#guardarVideo").click(function () {

        $("#ordenarVideo").show();
        $("#guardarVideo").hide();

        for (var i = 0; i < $("#galeriaVideo li").length; i++) {

            var actualizarOrden = new FormData();
            actualizarOrden.append("actualizarOrdenVideo", almacenarOrdenId[i]);
            actualizarOrden.append("actualizarOrdenItem", ordenItem[i]);

            $.ajax({

                url: "views/ajax/gestorVideos.php",
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
                                window.location = "videos";
                            }
                        });
                }
            })
        }
    })
})