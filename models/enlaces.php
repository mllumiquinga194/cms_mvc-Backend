<?php

class EnlacesModels{

    public function enlacesModel($enlaces){

        if ($enlaces == "inicio" ||
            $enlaces == "ingreso" ||
            $enlaces == "slide" ||
            $enlaces == "articulos" ||
            $enlaces == "galeria" ||
            $enlaces == "videos" ||
            $enlaces == "suscriptores" ||
            $enlaces == "mensajes" ||
            $enlaces == "salir" ||
            $enlaces == "perfil"){

                $module = "views/modules/".$enlaces.".php";

        }else if($enlaces == "index"){
            
            $module = "views/modules/ingreso.php";

        }else {

            $module = "views/modules/ingreso.php";

        }

        return $module;

    }

}