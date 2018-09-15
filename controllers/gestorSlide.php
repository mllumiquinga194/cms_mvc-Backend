<?php

class GestorSlide{

    /**MOSTRAR IMAGEN DEL SLIDE CN AJAX */

    public function mostarImagenController($datos){

        // getimagesize(): obtiene el tamaño de una imageantialias
        // LIST(): al igual que array no es realmente una funcion, es un constructor del lenguaje. LIST() se utiliza para asignar una lista de variables en una sola opcion.

        // tomame los primeros indices de la rspuesta del getimagesize y guardalo en las variables $ancho y $alto (indice 0 y indice 1 del $datos["imagenTemporal"])
        list($ancho, $alto) = getimagesize($datos["imagenTemporal"]);        

        if($ancho < 1600 || $alto < 600){

            echo 0;

        }else{

            $aleatorio = mt_rand(100, 999);

            $ruta = "../../views/images/slide/slide".$aleatorio.".jpg";

            // imagecreatefromjpeg() crea una nueva imagen a partir de un fichero o una url
            
            $origen = imagecreatefromjpeg($datos["imagenTemporal"]);

            //imagecrop() recort una imagen usando las coordenadas, el tamaño, x y, ancho y alto dadods

            $destino = imagecrop($origen, ["x"=>0, "y"=>0, "width"=>1600, "height"=>600]);

            // imagejpeg(): exporta la imagen al nevegador o a un fichero

            imagejpeg($destino, $ruta);

            GestorSlideModel::subirImagenSlideModel($ruta, "slide");

            // echo $respuesta;

            $respuesta = GestorSlideModel::mostrarImagenSlideModel($ruta, "slide");
            // respuesta es un arreglo ya que recibe los valores del Fetch por lo tanto lo guarto en la variable $enviarDatos con su propiedad correspondiente y lo envio al AJAX Y JS con el metodo de PHP json_encode

            $enviarDatos = array ("ruta" => $respuesta["ruta"],
                                    "titulo" => $respuesta["titulo"],
                                        "descripcion" => $respuesta["descripcion"]);

            echo json_encode($enviarDatos);
        }

    }    

    /**MOSTRAR IMAGENES N LA VISTA */

    public function mostrarImagenVistaController(){

        $respuesta = GestorSlideModel::mostrarImagenVistaModel("slide");

        foreach ($respuesta as $row => $item) {
            echo '<li  id="'.$item["id"].'" class="bloqueSlide">
                    <span class="fa fa-times eliminarSlide" ruta="'.$item["ruta"].'"></span>
                    <img src="'.substr($item["ruta"], 6).'" class="handleImg">
                </li>';
        }
    }

    public function editorSlideController(){

        $respuesta = GestorSlideModel::mostrarImagenVistaModel("slide");

        foreach ($respuesta as $row => $item) {
            echo '<li id="item'.$item["id"].'">
                    <span class="fa fa-pencil editarSlide" style="background:blue"></span>
                    <img src="'.substr($item["ruta"], 6).'" style="float:left; margin-bottom:10px" width="80%">
                    <h1>'.$item["titulo"].'</h1>
                    <p>'.$item["descripcion"].'</p>
                </li>';
        }
    }

    /**ELIMINAR ITEM DEL SLIDE */

    public function eliminarSlideController ($datos){
        
        $respuesta = GestorSlideModel::eliminarSlideModel($datos, "slide");

        unlink($datos["rutaSlide"]);

        echo $respuesta;
    }

    // ALTUALIZAR ORDEN

    public function actualizarSlideController ($datos){

        GestorSlideModel::actualizarSlideModel($datos, "slide");

        $respuesta = GestorSlideModel::seleccionarActualizacionSlideModel($datos, "slide");

        $enviarDatos = array ("titulo" => $respuesta["titulo"],
                                "descripcion" => $respuesta["descripcion"]);

        echo json_encode($enviarDatos);   
    }

    public function actualizarOrdenController ($datos){

        GestorSlideModel::actualizarOrdenModel($datos, "slide");

        $respuesta = GestorSlideModel::seleccionarOrdenModel("slide");

        foreach ($respuesta as $row => $item) {
            echo '<li id="item'.$item["id"].'">
                    <span class="fa fa-pencil editarSlide" style="background:blue"></span>
                    <img src="'.substr($item["ruta"], 6).'" style="float:left; margin-bottom:10px" width="80%">
                    <h1>'.$item["titulo"].'</h1>
                    <p>'.$item["descripcion"].'</p>
                </li>';
        }
    }

    public function visualizarSlideController (){

        $respuesta = GestorSlideModel::seleccionarOrdenModel("slide");

        foreach ($respuesta as $row => $item) {

            echo ('<li>
                    <img src="'.substr($item["ruta"], 6).'">
                    <div class="slideCaption">
                        <h3>'.$item["titulo"].'</h3>
                        <p>'.$item["descripcion"].'</p>
                    </div>
                </li>');
        }
        
    }
}