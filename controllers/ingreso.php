<?php

class Ingreso{

    public function ingresoController(){

        if(isset($_POST["usuarioIngreso"])){

            if(preg_match('/^[a-zA-Z0-9]*$/', $_POST["usuarioIngreso"]) &&
                preg_match('/^[a-zA-Z0-9]*$/', $_POST["passwordIngreso"])){

                $encriptar = crypt ($_POST["passwordIngreso"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');
            
                if(isset($_POST["usuarioIngreso"])){

                    $datosController = array("usuario" => $_POST["usuarioIngreso"],
                                            "password" => $encriptar);

                    $respuesta = IngresoModels::ingresoModel($datosController, "usuarios");

                    $intentos = $respuesta["intentos"];
                    $maximoIntentos = 2;
                    $usuarioActal = $_POST["usuarioIngreso"];

                    if ($intentos < $maximoIntentos){

                        if($respuesta["usuario"] ==  $_POST["usuarioIngreso"] &&
                            $respuesta["password"] == $encriptar){

                            $intentos = 0;

                            $datosController = array ("usuarioActual" => $usuarioActal,"actualizarIntentos" => $intentos);
                            
                            $respuestaActualizarIntentos = IngresoModels::intentosModel($datosController, "usuarios");

                            session_start();

                            $_SESSION["validar"] = true;
                            $_SESSION["usuario"] = $respuesta["usuario"];
                            $_SESSION["id"] = $respuesta["id"];
                            $_SESSION["password"] = $respuesta["password"];
                            $_SESSION["email"] = $respuesta["email"];
                            $_SESSION["photo"] = $respuesta["photo"];
                            $_SESSION["rol"] = $respuesta["rol"];

                            
                            header("location:inicio");
                            // echo "Ingreso Correctamente!!";

                        }else{

                            ++$intentos;

                            $datosController = array ("usuarioActual" => $usuarioActal,"actualizarIntentos" => $intentos);
                            
                            $respuestaActualizarIntentos = IngresoModels::intentosModel($datosController, "usuarios");

                            echo '<div class="alert alert-danger">Error al Ingresar!!</div>';
                        }
                    }else{

                        $intentos = 0;

                            $datosController = array ("usuarioActual" => $usuarioActal,"actualizarIntentos" => $intentos);
                            
                            $respuestaActualizarIntentos = IngresoModels::intentosModel($datosController, "usuarios");

                            // header("location:index.php?action=fallo3intentos");
                            echo '<div class="alert alert-danger">Ha Fallado 3 Veces, Demuestre que  no es un robot!!</div>';
                    }
                }
            }
        }
    }
}