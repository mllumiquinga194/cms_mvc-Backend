            <!--=====================================
			ingreso         
			======================================-->
<div id="backIngreso">

    <form method="post" id="formIngreso" onsubmit="return validarIngreso">

        <h1 id="tituloFormIngreso">INGRESO AL PANEL DE CONTROL</h1>
        
        <input class="form-control formIngreso" type="text" placeholder="Ingrese su Usuario" id="usuarioIngreso" name="usuarioIngreso">
        <input class="form-control formIngreso" type="password" placeholder="Ingrese su Contraseña" id="passwordIngreso" name="passwordIngreso">
        <?php
            $ingreso = new Ingreso();
            $ingreso -> ingresoController();
        ?>
        <input class="form-control formIngreso btn btn-primary" type="submit" value="Enviar">

    </form>
    
</div>


            <!--====  Fin de ingresos  ====-->