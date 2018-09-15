<?php

class Enlaces{

    public function enlacesController(){

        if(isset($_GET["action"])){

            $enlaces = $_GET["action"];

        }else{

            $enlaces = "index";

        }

        $respuesta = EnlacesModels::enlacesModel($enlaces);

        include $respuesta; 

    }
}