<?php

class GestorArticulos{

	#MOSTRAR IMAGEN ARTÍCULO
	#------------------------------------------------------------
	public function mostrarImagenController($datos){

        list($ancho, $alto) = getimagesize($datos);

		if($ancho < 800 || $alto < 400){

			echo 0;

		}else{
            // para generar un nombre diferente.
            $aleatorio = mt_rand(100, 999);
            // mientras decido cual es la imagen definitiva, subo las imagenes a la carpeta temp
            $ruta = "../../views/images/articulos/temp/articulo".$aleatorio.".jpg";
            // lo que yo recibi en el ajax, conviertelo a una imagen y guardalo en la variable origen.
            $origen = imagecreatefromjpeg($datos);
            // esa imagen necesito que me la cortes tomando en cuenta estas coordenadas
            $destino = imagecrop($origen, ["x"=>0, "y"=>0, "width"=>800, "height"=>400]);
            // esta funcion me permite guardar la imagen que esta en $DESTINO en la direccion que esta en $RUTA
			imagejpeg($destino, $ruta);

			echo $ruta;
		}
    }

    #GUARDAR ARTICULO
	#-----------------------------------------------------------
	// esta funcion se llama directamente desde el modulo ARTICULOS. desde el form
	public function guardarArticuloController(){

		if(isset($_POST["tituloArticulo"])){

            // en esta variable imagen, recibo el archivo temporal que esta en el formulario
            $imagen = $_FILES["imagen"]["tmp_name"];

            // con este metodo borro todos los archivos que estan en la carpeta temporal. aqui se guardaron las imagenes que cambié.
			$borrar = glob("views/images/articulos/temp/*");
            // foreach hace lectura de las imagenes que estan en las variables borrar  y las tomo como archivo y a ese archivo le aplico el metodo unlink()
			foreach($borrar as $file){

				unlink($file);

			}

			$aleatorio = mt_rand(100, 999);

            // guardo la imagen definitiva en la ruta definitiva.
			$ruta = "views/images/articulos/articulo".$aleatorio.".jpg";

			$origen = imagecreatefromjpeg($imagen);

			$destino = imagecrop($origen, ["x"=>0, "y"=>0, "width"=>800, "height"=>400]);

            imagejpeg($destino, $ruta);
            
// para mandar a la base de datos todos los post que me estan llegando del formulario
			$datosController = array("titulo"=>$_POST["tituloArticulo"],
				                     "introduccion"=>$_POST["introArticulo"]."...",
			 	                      "ruta"=>$ruta,
			 	                      "contenido"=>$_POST["contenidoArticulo"]);

			$respuesta = GestorArticulosModel::guardarArticuloModel($datosController, "articulos");

			if($respuesta == "ok"){

				echo'<script>

					swal({
						  title: "¡OK!",
						  text: "¡El artículo ha sido creado correctamente!",
						  type: "success",
						  confirmButtonText: "Cerrar",
						  closeOnConfirm: false
					},

					function(isConfirm){
							 if (isConfirm) {	   
							    window.location = "articulos";
							  } 
					});


				</script>';

			}

			else{

				echo $respuesta;

			}
        }
	}

	#GUARDAR ARTICULO
	#-----------------------------------------------------------
	// esta funcion de llama desde el modulo articulos
	public	function mostrarArticulosController(){

		$respuesta = GestorArticulosModel::mostrarArticulosModel("articulos");

		foreach ($respuesta as $row => $item) {
			echo '<li id="'.$item["id"].'" class="bloqueArticulo">
					<span class="handleArticle">
						<a href="index.php?action=articulos&idBorrar='.$item["id"].'&rutaImagen='.$item["ruta"].'">
							<i class="fa fa-times btn btn-danger"></i>
						</a>
						<i class="fa fa-pencil btn btn-primary editarArticulo"></i>	
					</span>
					<img src="'.$item["ruta"].'" class="img-thumbnail">
					<h1>'.$item["titulo"].'</h1>
					<p>'.$item["introduccion"].'</p>
					<input type="hidden" value="'.$item["contenido"].'">
					<a href="#articulo'.$item["id"].'" data-toggle="modal">
						<button class="btn btn-default">Leer Más</button>
					</a>

				</li>

				<div id="articulo'.$item["id"].'" class="modal fade">

					<div class="modal-dialog modal-content">

						<div class="modal-header" style="border:1px solid #eee">
						
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h3 class="modal-title">'.$item["titulo"].'</h3>
								
						</div>

						<div class="modal-body" style="border:1px solid #eee">
								
							<img src="'.$item["ruta"].'" width="100%" style="margin-bottom:20px">
							<p class="parrafoContenido text-justify">'.$item["contenido"].'</p>
								
						</div>

						<div class="modal-footer" style="border:1px solid #eee">
								
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						
						</div>

					</div>

				</div>';
		}		
	}

		#BORRAR ARTICULO
	#-----------------------------------------------------------

	public function borrarArticuloController(){

		if(isset($_GET["idBorrar"])){

			unlink($_GET["rutaImagen"]);

			$datosController = $_GET["idBorrar"];

			$respuesta = GestorArticulosModel::borrarArticuloModel($datosController, "articulos");
			
			if($respuesta == "ok"){

					echo'<script>

							swal({
									title: "¡OK!",
									text: "¡El artículo se ha borrado correctamente!",
									type: "success",
									confirmButtonText: "Cerrar",
									closeOnConfirm: false
							},

							function(isConfirm){
										if (isConfirm) {	   
										window.location = "articulos";
										} 
							});

						</script>';

			}
		}
	}

	#ACTUALIZAR ARTICULO
	#-----------------------------------------------------------

	public function editarArticuloController(){

		// si la ruta esta vacia, significa que no realice cambio de imagen al momento d editar
		$ruta = "";

		if(isset($_POST["editarTitulo"])){

			if(isset($_FILES["editarImagen"]["tmp_name"])){	//si recibo este files es porque cambie la imangen editando

				$imagen = $_FILES["editarImagen"]["tmp_name"];

				$aleatorio = mt_rand(100, 999);

				$ruta = "views/images/articulos/articulo".$aleatorio.".jpg";

				$origen = imagecreatefromjpeg($imagen);

				$destino = imagecrop($origen, ["x"=>0, "y"=>0, "width"=>800, "height"=>400]);

				imagejpeg($destino, $ruta);

				// commo ya elegi una foto, borro las que estan en la carpeta temp
				$borrar = glob("views/images/articulos/temp/*");

				foreach($borrar as $file){
				
					unlink($file);
				
				}
			}

			// si ruta continua vacia es porque no cambie la imagen
			if($ruta == ""){

				// por lo cual acepto la ruta de la imagen que ya tenia. 
				$ruta = $_POST["fotoAntigua"];

			}else{
				// si ya tengo una imagen nueva, borro la vieja de la carpeta
				unlink($_POST["fotoAntigua"]);

			}
// acepto los datos del form que esta en el .js
			$datosController = array("id"=>$_POST["id"], //id que esta oculto en el input.
			                         "titulo"=>$_POST["editarTitulo"],
								     "introduccion"=>$_POST["editarIntroduccion"],
								     "ruta"=>$ruta,
								     "contenido"=>$_POST["editarContenido"]);

			$respuesta = GestorArticulosModel::editarArticuloModel($datosController, "articulos");

			if($respuesta == "ok"){

				echo'<script>

					swal({
						  title: "¡OK!",
						  text: "¡El artículo ha sido actualizado correctamente!",
						  type: "success",
						  confirmButtonText: "Cerrar",
						  closeOnConfirm: false
					},

					function(isConfirm){
							 if (isConfirm) {	   
							    window.location = "articulos";
							  } 
					});


				</script>';

			}

			else{

				echo $respuesta;

			}
		}
	}
		#ACTUALIZAR ORDEN 
	#---------------------------------------------------
	public function actualizarOrdenController($datos){

		GestorArticulosModel::actualizarOrdenModel($datos, "articulos");

		$respuesta = GestorArticulosModel::seleccionarOrdenModel("articulos");

		foreach($respuesta as $row => $item){

			echo ' <li id="'.$item["id"].'" class="bloqueArticulo">
					<span class="handleArticle">
					<a href="index.php?action=articulos&idBorrar='.$item["id"].'&rutaImagen='.$item["ruta"].'">
						<i class="fa fa-times btn btn-danger"></i>
					</a>
					<i class="fa fa-pencil btn btn-primary editarArticulo"></i>	
					</span>
					<img src="'.$item["ruta"].'" class="img-thumbnail">
					<h1>'.$item["titulo"].'</h1>
					<p>'.$item["introduccion"].'</p>
					<input type="hidden" value="'.$item["contenido"].'">
					<a href="#articulo'.$item["id"].'" data-toggle="modal">
					<button class="btn btn-default">Leer Más</button>
					</a>

					<hr>

				</li>

				<div id="articulo'.$item["id"].'" class="modal fade">

					<div class="modal-dialog modal-content">

						<div class="modal-header" style="border:1px solid #eee">
				        
							<button type="button" class="close" data-dismiss="modal">&times;</button>
						 <h3 class="modal-title">'.$item["titulo"].'</h3>
			        
						</div>

						<div class="modal-body" style="border:1px solid #eee">
			        
							<img src="'.$item["ruta"].'" width="100%" style="margin-bottom:20px">
							<p class="parrafoContenido">'.$item["contenido"].'</p>
			        
						</div>

						<div class="modal-footer" style="border:1px solid #eee">
			        
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			        
						</div>

					</div>

				</div>';

		}


	}
}