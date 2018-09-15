<?php

class GestorGaleria{

	#MOSTRAR IMAGEN GALERIA AJAX
	#------------------------------------------------------------
	public function mostrarImagenController($datos){

		list($ancho, $alto) = getimagesize($datos);

		if($ancho < 1024 || $alto < 768){

			echo 0;

		}

		else{

			$aleatorio = mt_rand(100, 999);

			$ruta = "../../views/images/galeria/galeria".$aleatorio.".jpg";//como estoy siendo llamado del Ajax, salgo del ajax, salgo de la vista voy a la ruta

			$nuevo_ancho = 1024;
			$nuevo_alto = 768;

			$origen = imagecreatefromjpeg($datos);#crea una imagen a partir de las propiedades recibidas.

            #imagecreatetruecolor — Crear una nueva imagen de color verdadero
            // con esta funcion en realidad estoy creando un area donde luego copiare la imagen anterior.
			$destino = imagecreatetruecolor($nuevo_ancho, $nuevo_alto);

			#imagecopyresized() - copia una porción de una imagen a otra imagen. 

			#bool imagecopyresized( $destino, $origen, int $destino_x, int $destino_y, int $origen_x, int $origen_y, int $destino_w, int $destino_h, int $origen_w, int $origen_h)
            #con esta funcion, realmente estoy montando sobre el area creada anteriormente, la imagen $ORIGEN. ORIGEN LA COLOCO EN DSTINO CON SUS NUEVAS PROPIEDASDES
			imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevo_ancho, $nuevo_alto, $ancho, $alto);

			imagejpeg($destino, $ruta);

			GestorGaleriaModel::subirImagenGaleriaModel($ruta, "galeria");

			$respuesta = GestorGaleriaModel::mostrarImagenGaleriaModel($ruta, "galeria");

			echo $respuesta["ruta"];

		}

	}

	#MOSTRAR IMAGENES EN LA VISTA
	#------------------------------------------------------------

	public function mostrarImagenVistaController(){

		$respuesta = GestorGaleriaModel::mostrarImagenVistaModel("galeria");

		foreach($respuesta as $row => $item){
            // al span le coloque el atributo RUTA para cuando le de click al icono de borrar, obtenga esa ruta y poder borrarla de la carpeta de imagenes
			echo '<li id="'.$item["id"].'" class="bloqueGaleria">
					<span class="fa fa-times eliminarFoto" ruta="'.$item["ruta"].'"></span>
					<a rel="grupo" href="'.substr($item["ruta"],6).'">
					<img src="'.substr($item["ruta"],6).'" class="handleImg">
					</a>
				</li>';

		}

	}

	#ELIMINAR ITEM DE LA GALERIA
	#-----------------------------------------------------------
	public function eliminarGaleriaController($datos){

		$respuesta = GestorGaleriaModel::eliminarGaleriaModel($datos, "galeria");

		unlink($datos["rutaGaleria"]);

		echo $respuesta;

	}

	#ACTUALIZAR ORDEN 
	#---------------------------------------------------
	public function actualizarOrdenController($datos){

		GestorGaleriaModel::actualizarOrdenModel($datos, "galeria");

		$respuesta = GestorGaleriaModel::seleccionarOrdenModel("galeria");

		foreach($respuesta as $row => $item){

			// la clase bloque galeria la voy a usar en l sortable para conectar los bloues con que voy a mover las imagenes.
			// el atributo RUTA del span es para poder borrar las imagenes de la carpeta a la hora de dar click al icoco de borrar
			// la clase handleImg es para tomar las imagenes y poder moverlas desde el sortable
			echo '<li id="'.$item["id"].'" class="bloqueGaleria">
					<span class="fa fa-times eliminarFoto" ruta="'.$item["ruta"].'"></span>
					<a rel="grupo" href="'.substr($item["ruta"],6).'">
					<img src="'.substr($item["ruta"],6).'" class="handleImg">
					</a>
				</li>';

		}


	}

}