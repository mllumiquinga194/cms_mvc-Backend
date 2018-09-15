<?php

require_once "../../controllers/gestorSlide.php";
require_once "../../models/gestorSlide.php";

/**CLASES Y METODODS
 * *******************************************************************/
class Ajax{
     
// SUBIR LA IMAGEN DEL SLIDE
    public $nombreImagen;
    public $imagenTemporal;

    public function gestorSlideAjax(){
        // para llenar el array aqui en esta mierda no se le pone el simbolo de DOLAR $$$$$$ en las variables
            $datos = array ("nombreImagen" => $this -> nombreImagen,
                            "imagenTemporal" => $this -> imagenTemporal);

            $respuesta = GestorSlide::mostarImagenController($datos);
            // $respuesta = GestorSlide::mostrarImagenVistaController();

            echo $respuesta;
    }

    /**EIMINAR ITEM SLIDE */
    public $idSlide;
    public $rutaSlide;

    public function eliminarSlideAjax(){

        $datos = array ("idSlide" => $this -> idSlide,
                        "rutaSlide" => $this -> rutaSlide);

        $respuesta = GestorSlide::eliminarSlideController($datos);

        echo $respuesta;

    }
    
    /**EDITAR-ACTUALIZAR ITEM SLIDE */
    public $enviarId;
    public $enviarTitulo;
    public $enviarDescripcion;

    public function actualizarSlideAjax(){

        $datos = array ("enviarId" => $this -> enviarId,
                        "enviarTitulo" => $this -> enviarTitulo,
                        "enviarDescripcion" => $this -> enviarDescripcion);

        $respuesta = GestorSlide::actualizarSlideController($datos);

        echo $respuesta;

    }

        /**ORDENAR ITEM SLIDE */
        public $actualizarOrdenSlide;
        public $actualizarOrdenItem;

        public function actualizarOrdenAjax(){

        $datos = array ("ordenSlide" => $this -> actualizarOrdenSlide,
                        "ordenItem" => $this -> actualizarOrdenItem);

        $respuesta = GestorSlide::actualizarOrdenController($datos);

        echo $respuesta;

        }

    
}
/**METODODS
 * *******************************************************************/

if(isset($_FILES["imagen"]["name"])){
// para acceder aqui tampoco se utiliza el simbolo de DOLAR $$$$$$$$$$$$$4
	$a = new Ajax();
	$a -> nombreImagen = $_FILES["imagen"]["name"];
	$a -> imagenTemporal = $_FILES["imagen"]["tmp_name"];
	$a -> gestorSlideAjax();

}
/**ELIMINAR ID DE SLIDE EN LA BASE DE DATOS */
if(isset($_POST["idSlide"])){

    $b = new Ajax();
    $b -> idSlide = $_POST["idSlide"];
    $b -> rutaSlide = $_POST["rutaSlide"];
    $b -> eliminarSlideAjax();
}
/**ACTUALIZAR TITULO T DESCRIPCION DEl SLIDE EN LA BASE DE DATOS */
if(isset($_POST["enviarId"])){

    $c = new Ajax();
    $c -> enviarId = $_POST["enviarId"];
    $c -> enviarTitulo = $_POST["enviarTitulo"];
    $c -> enviarDescripcion = $_POST["enviarDescripcion"];
    $c -> actualizarSlideAjax();
}

if(isset($_POST["actualizarOrdenSlide"])){

    $d = new Ajax();
    $d -> actualizarOrdenSlide = $_POST["actualizarOrdenSlide"];
    $d -> actualizarOrdenItem = $_POST["actualizarOrdenItem"];
    $d -> actualizarOrdenAjax();
}