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
			SUSCRIPTORES         
			======================================-->
			
<div id="suscriptores" class="col-lg-10 col-md-10 col-sm-9 col-xs-12">
    
    <div>

    <table id="tablaSuscriptores" class="table table-striped dt-responsive nowrap">
    <thead>
        <tr>
        <th>Usuario</th>
        <th>Email</th>
        <th>Acciones</th>
        <th></th>
        </tr>
    </thead>
    <tbody>

    <?php
        $suscriptores = new SuscriptoresController();
        $suscriptores -> mostrarSuscriptoresController();
        $suscriptores -> borrarSuscriptoresController();
    ?>
    </tbody>
    </table>
    <a href="tcpdf/pdf/suscriptores.php" target="blank">
        <button class="btn btn-warning pull-right" style="margin:20px;">Imprimir Suscriptores</button>
    </a>
    </div>

</div>
<script>
  
$(window).load(function(){

  var datos = new FormData();

  datos.append("revisionSuscriptores", 1);

  $.ajax({
      url:"views/ajax/gestorRevision.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      success: function(respuesta){
          console.log("respuesta", respuesta);
          
      }

    });
})

</script>
		
			<!--====  Fin de SUSCRIPTORES  ====-->