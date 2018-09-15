<?php

require_once "../../controllers/gestorArticulos.php";
require_once "../../models/gestorArticulos.php";

class Ajax{

    /**SUBIR IMAGEN DEL ARICULO */

    public $imagenTemporal;
    
    public function gestorArticulosAjax(){

        $datos = $this->imagenTemporal;

        $respuesta = GestorArticulos::mostrarImagenController($datos);

		echo $respuesta;
    }

    	#ACTUALIZAR ORDEN
	#---------------------------------------------
	public $actualizarOrdenArticulos;
	public $actualizarOrdenItem;

	public function actualizarOrdenAjax(){	

		$datos = array("ordenArticulos" => $this->actualizarOrdenArticulos,
			           "ordenItem" => $this->actualizarOrdenItem);

		$respuesta = GestorArticulos::actualizarOrdenController($datos);

		echo $respuesta;

	}
}

// OBJETOS========================

if(isset($_FILES["imagen"]["tmp_name"])){

	$a = new Ajax();
	$a -> imagenTemporal = $_FILES["imagen"]["tmp_name"];
	$a -> gestorArticulosAjax();

}

if(isset($_POST["actualizarOrdenArticulos"])){

	$b = new Ajax();
	$b -> actualizarOrdenArticulos = $_POST["actualizarOrdenArticulos"];
	$b -> actualizarOrdenItem = $_POST["actualizarOrdenItem"];
	$b -> actualizarOrdenAjax();

}