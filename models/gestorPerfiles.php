<?php

require_once "conexion.php";

class GestorPerfilesModel{

	#GUARDAR PERFIL
	#------------------------------------------------------------
	public function guardarPerfilModel($datosModel, $tabla){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (usuario, password, email, photo, rol) VALUES (:usuario, :password, :email, :photo, :rol)");

		$stmt -> bindParam(":usuario", $datosModel["usuario"], PDO::PARAM_STR);
		$stmt -> bindParam(":password", $datosModel["password"], PDO::PARAM_STR);
		$stmt -> bindParam(":email", $datosModel["email"], PDO::PARAM_STR);
		$stmt -> bindParam(":photo", $datosModel["photo"], PDO::PARAM_STR);
		$stmt -> bindParam(":rol", $datosModel["rol"], PDO::PARAM_INT);

		if($stmt->execute()){

			return "ok";
		}

		else{

			return "error";
		}

		$stmt->close();

	}

	#VISUALIZAR PERFILES
	#------------------------------------------------------
	public function verPerfilesModel($tabla){

		$stmt = Conexion::conectar()->prepare("SELECT id, usuario, password,  email, rol, photo FROM $tabla");

		$stmt -> execute();

		return $stmt -> fetchAll();

		$stmt -> close();

	}

	#ACTUALIZAR PERFIL
	#---------------------------------------------------
	public function editarPerfilModel($datosModel, $tabla){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET usuario = :usuario, password = :password, email = :email, rol = :rol, photo = :photo WHERE id = :id");	

		$stmt -> bindParam(":usuario", $datosModel["usuario"], PDO::PARAM_STR);
		$stmt -> bindParam(":password", $datosModel["password"], PDO::PARAM_STR);
		$stmt -> bindParam(":email", $datosModel["email"], PDO::PARAM_STR);
		$stmt -> bindParam(":rol", $datosModel["rol"], PDO::PARAM_INT);
		$stmt -> bindParam(":photo", $datosModel["photo"], PDO::PARAM_STR);
		$stmt -> bindParam(":id", $datosModel["id"], PDO::PARAM_INT);

		if($stmt->execute()){

			return "ok";
			
		}else{

			return "error";
		}

		$stmt->close();

	}

	#BORRAR PERFIL
	#-----------------------------------------------------
	public function borrarPerfilModel($datosModel, $tabla){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");

		$stmt->bindParam(":id", $datosModel, PDO::PARAM_INT);

		if($stmt->execute()){

			return "ok";

		}

		else{

			return "error";

		}

		$stmt->close();

	}


}