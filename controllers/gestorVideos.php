<?php

class GestorVideos{

	#MOSTRAR VIDEO AJAX
	#------------------------------------------------------------

	public function mostrarVideoController($datos){

		$aleatorio = mt_rand(100, 999);

		$ruta = "../../views/videos/video".$aleatorio.".mp4";

		move_uploaded_file($datos, $ruta);

		GestorVideosModel::subirVideoModel($ruta, "videos");

		$respuesta = GestorVideosModel::mostrarVideoModel($ruta, "videos");

		$enviarDatos = $respuesta["ruta"];

		echo $enviarDatos;

	}

	#MOSTRAR VIDEOS EN LA VISTA
	#------------------------------------------------------------
	public function mostrarVideoVistaController(){

		$respuesta = GestorVideosModel::mostrarVideoVistaModel("videos");

		foreach($respuesta as $row => $item){

			echo '<li id="'.$item["id"].'" class="bloqueVideo">
					<span class="fa fa-times eliminarVideo" ruta="'.$item["ruta"].'"></span>
					<video controls class="handleVideo">
						<source src="'.substr($item["ruta"],6).'" type="video/mp4">
					</video>	
				</li>';

		}

	}

	#ELIMINAR VIDEO
	#-----------------------------------------------------------
	public function eliminarVideoController($datos){

		$respuesta = GestorVideosModel::eliminarVideoModel($datos, "videos");

		unlink($datos["rutaVideo"]);

		echo $respuesta;

	}

	#ACTUALIZAR ORDEN 
	#---------------------------------------------------
	public function actualizarOrdenController($datos){

		GestorVideosModel::actualizarOrdenModel($datos, "videos");

		$respuesta = GestorVideosModel::seleccionarOrdenModel("videos");

		foreach($respuesta as $row => $item){

			echo '<li id="'.$item["id"].'" class="bloqueVideo">
					<span class="fa fa-times eliminarVideo" ruta="'.$item["ruta"].'"></span>
					<video controls class="handleVideo">
						<source src="'.substr($item["ruta"],6).'" type="video/mp4">
					</video>	
				</li>';

		}

	}

}