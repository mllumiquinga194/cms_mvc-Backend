<?php

class SuscriptoresController{

	#MOSTRAR SUSCRIPTORES EN LA VISTA
	#------------------------------------------------------------
	public function mostrarSuscriptoresController(){

		$respuesta = SuscriptoresModel::mostrarSuscriptoresModel("suscriptores");

		foreach ($respuesta as $row => $item){

			echo '<tr>
			        <td>'.$item["nombre"].'</td>
			        <td>'.$item["email"].'</td>
			        <td>
			        	<a href="index.php?action=suscriptores&idBorrar='.$item["id"].'"><span class="btn btn-danger fa fa-times quitarSuscriptor"></span></a>
			        </td>
			        <td>
			        </td>
			      </tr>';

		}

	}

	#BORRAR Suscriptores
	#------------------------------------------------------------

	public function borrarSuscriptoresController(){

		if(isset($_GET["idBorrar"])){

			$datosController = $_GET["idBorrar"];

			$respuesta = SuscriptoresModel::borrarSuscriptoresModel($datosController, "suscriptores");

			if($respuesta == "ok"){

					echo'<script>

							swal({
								  title: "¡OK!",
								  text: "¡El suscrito se ha borrado correctamente!",
								  type: "success",
								  confirmButtonText: "Cerrar",
								  closeOnConfirm: false
							},

							function(isConfirm){
									 if (isConfirm) {	   
									    window.location = "suscriptores";
									  } 
							});


						</script>';

			}

		}

	}

	#IMPRESIÓN SUSCRIPTORES
	#------------------------------------------------------------

	public function impresionSuscriptoresController($datos){

		$datosController = $datos;

		$respuesta = SuscriptoresModel::mostrarSuscriptoresModel($datosController);
	
		return $respuesta;

	}
		#SUSCRIPTORES SIN REVISAR
	#------------------------------------------------------------
	public function suscriptoresSinRevisarController(){

		$respuesta = SuscriptoresModel::suscriptoresSinRevisarModel("suscriptores");

		$sumaRevision = 0;

		foreach ($respuesta as $row => $item) {
			
			if($item["revision"] == 0){

				++$sumaRevision;

				echo '<span>'.$sumaRevision.'</span>';

			}					
		
		}

	}
		#SUSCRIPTORES REVISADOS
	#------------------------------------------------------------
	public function suscriptoresRevisadosController($datos){

		$datosController = $datos;

		$respuesta = SuscriptoresModel::suscriptoresRevisadosModel($datosController, "suscriptores");

		echo $respuesta;

	}

}