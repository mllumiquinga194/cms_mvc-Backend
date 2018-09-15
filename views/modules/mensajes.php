<?php

    session_start();

    if(!$_SESSION["validar"]){

        header("location:ingreso");

        exit();

    }
    include "views/modules/botonera.php";
    include "views/modules/cabezote.php";

?>

			<!--=====================================
			MENSAJES        
			======================================-->
			
<div id="bandejaMensajes" class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
    
        <div >
        <h1>Bandeja de Entrada</h1>
        <hr>
        </div>

        <?php
            $mostrarMensajes = new MensajesController();
            $mostrarMensajes -> mostrarMensajesController();
            $mostrarMensajes -> borrarMensajesController();
        ?>


</div>

<div id="lecturaMensajes" class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
    
        <div >
        <hr>
        <button class="btn btn-success" id="enviarCorreoMasivo">Enviar mensaje a todos los usuarios</button>
        <hr>
        </div>

        <div id="visorMensajes">
        
            <?php
                $responderMensaje = new MensajesController();
                $responderMensaje -> responderMensajesController();
                $responderMensaje -> mensajesMasivosController();
            ?>

        </div>
        
        </div>

</div>
<script>
 //para avisarnos cuando carga la pag y poder borrar las notificaciones de mensajes
    $(window).load(function(){
        var datos = new FormData();

        datos.append("revisionMensajes", 1);

        $.ajax({

            url: "views/ajax/gestorRevision.php",
            method:"POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            success: function(respuesta){
                
                console.log("respuesta", respuesta);
            }
        });
    });
    
</script>

			<!--====  Fin de MENSAJES  ====-->