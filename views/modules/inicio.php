<!--=====================================
			INICIO       
			======================================-->

<?php

    session_start();

    if(!$_SESSION["validar"]){

        header("location:ingreso");

        exit();

    }
    include "views/modules/botonera.php";
    include "views/modules/cabezote.php";

?>
			
<div id="inicio" class="col-lg-10 col-md-10 col-sm-9 col-xs-12">
    
    <div class="jumbotron">
        <h1>Bienvenidos</h1>
        <p>Bienvenidos al panel de control.</p>
    </div>

        <hr>
    
    <ul>

        <li class="botonesInicio">
        
            <a href="slide">
            <div style="background:#4CF53A">
            <span class="fa fa-toggle-right"></span>
            <p>Slide</p>
            </div>
            </a>

        </li>

        <li class="botonesInicio">
        
            <a href="articulos">
            <div style="background:#F640DA">
            <span class="fa fa-file-text-o"></span>
            <p>Artículos</p>
            </div>
            </a>

        </li>

        <li class="botonesInicio">
        
            <a href="galeria">
            <div style="background:#04E6DE">
            <span class="fa fa-image"></span>
            <p>Imágenes</p>
            </div>
            </a>

        </li>

        <li class="botonesInicio">
        
            <a href="videos">
            <div style="background:#1434AD"> 
            <span class="fa fa-film"></span>
            <p>Videos</p>
            </div>
            </a>

        </li>

        
        <?php

            if ($_SESSION["rol"]== 0){

                echo
                    '<li class="botonesInicio">
                    
                        <a href="suscriptores">
                        <div style="background:#ED3E3E">
                        <span class="fa fa-users"></span>
                        <p>Suscriptores</p>
                        </div>
                        </a>

                    </li>';
            }
        ?>

    </ul>

</div>

    	
			<!--====  Fin de INICIO  ====-->