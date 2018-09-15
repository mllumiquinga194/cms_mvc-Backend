<?php

require_once "../../models/gestorVideos.php";
require_once "../../controllers/gestorVideos.php";

#CLASE Y MÉTODOS
#-------------------------------------------------------------

class Ajax{

	#SUBIR EL VIDEO
	#----------------------------------------------------------
	public $videoTemporal;

	public function gestorVideoAjax(){

		$datos = $this->videoTemporal;

		$respuesta = GestorVideos::mostrarVideoController($datos);

		echo $respuesta;

	}

	#ELIMINAR ITEM VIDEO
	#----------------------------------------------------------
	public $idVideo;
	public $rutaVideo;

	public function eliminarVideoAjax(){

		$datos = array("idVideo" => $this->idVideo, 
			           "rutaVideo" => $this->rutaVideo);	

		$respuesta = GestorVideos::eliminarVideoController($datos);

		echo $respuesta;

	}

	#ACTUALIZAR ORDEN
	#---------------------------------------------
	public $actualizarOrdenVideo;
	public $actualizarOrdenItem;

	public function actualizarOrdenAjax(){

		$datos = array("ordenVideo" => $this->actualizarOrdenVideo,
			           "ordenItem" => $this->actualizarOrdenItem);

		$respuesta = GestorVideos::actualizarOrdenController($datos);

		echo $respuesta;
		
	}

}

#OBJETOS
#-----------------------------------------------------------
if(isset($_FILES["video"]["tmp_name"])){

	$a = new Ajax();
	$a -> videoTemporal = $_FILES["video"]["tmp_name"];
	$a -> gestorVideoAjax();

}

if(isset($_POST["idVideo"])){

	$b = new Ajax();
	$b -> idVideo = $_POST["idVideo"];
	$b -> rutaVideo = $_POST["rutaVideo"];
	$b -> eliminarVideoAjax();	

}

if(isset($_POST["actualizarOrdenVideo"])){

	$c = new Ajax();
	$c -> actualizarOrdenVideo = $_POST["actualizarOrdenVideo"];
	$c -> actualizarOrdenItem = $_POST["actualizarOrdenItem"];
	$c -> actualizarOrdenAjax();

}