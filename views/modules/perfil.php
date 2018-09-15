<?php

    session_start();

    if(!$_SESSION["validar"]){

        header("location:ingreso");

        exit();

    }
    include "views/modules/botonera.php";
    include "views/modules/cabezote.php";

?>

<!--=====================================
PERFIL       
======================================-->
			
<div id="editarPerfil" class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
    
    <h1>Hola <?php echo $_SESSION["usuario"];?> 

        <span class="btn btn-info fa fa-pencil pull-left" id="btnEditarPerfil" style="font-size:10px; margin-right:10px"></span>
    
    </h1>
    <div style="position:relative">

        <img src="<?php echo $_SESSION["photo"]; ?>" class="img-circle pull-right">

    </div>

    <hr>

    <h4>Perfil: 
        <?php 
                    if($_SESSION["rol"] == 0){

                        echo "Administrador";

                    }else{

                        echo "Editor";
                    }
        ?>
    </h4>

    <h4>Email: <?php echo $_SESSION["email"];?></h4>

    <h4>Contraseña: *********</h4>

</div>

<!--=====================================
EDITAR PERFIL       
======================================-->

<div id="formEditarPerfil" style="display:none" class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
  
    <form style="padding:20px" method="post" enctype="multipart/form-data">

        <input name="idPerfil" type="hidden" value="<?php echo $_SESSION["id"];?>"> <!--para saber que perfil voy a cambiar   -->

        <input name="actualizarSesion" type="hidden" value="ok">
        
        <div class="form-group">
        
            <input name="editarUsuario" type="text" class="form-control" value="<?php echo $_SESSION["usuario"];?>" required>

        </div>

        <div class="form-group">

            <input name="editarPassword" type="password" placeholder="Ingrese la Contraseña hasta 10 caracteres" maxlength="10" class="form-control" required>

        </div>

        <div class="form-group">

            <input name="editarEmail" type="email" value="<?php echo $_SESSION["email"];?>" class="form-control" required>

        </div>

        <div class="form-group">

            <select name="editarRol" class="form-control" required>

                <option value="">Seleccione el Rol</option>
                <option value="0">Administrador</option>
                <option value="1">Editor</option>

            </select>

        </div>

        <div class="form-group text-center">

            <img src="<?php echo $_SESSION["photo"]; ?>" width="20%" class="img-circle">

            <input type="hidden" value="<?php echo $_SESSION["photo"]; ?>" name="editarPhoto">
            
            <input type="file" class="btn btn-default" id="cambiarFotoPerfil" style="display:inline-block; margin:10px 0">

            <p class="text-center" style="font-size:12px">Tamaño recomendado de la imagen: 100px * 100px, peso máximo 2MB</p>

        </div>

            <input type="submit" id="guardarPerfil" value="Actualizar Perfil" class="btn btn-primary">

    </form>

</div>

    
<!--=====================================
CREAR PERFIL       
======================================-->

<?php

if ($_SESSION["rol"]== 0){

    echo 
        '<div id="crearPerfil" class="col-lg-6 col-md-6 col-sm-6 col-xs-12">

            <button id="registrarPerfil" style="margin-bottom:20px" class="btn btn-default">Registrar un nuevo miembro</button>

            <form id="formularioPerfil" style="display:none" method="post" enctype="multipart/form-data">
                
                <div class="form-group">
                
                    <input name="nuevoUsuario" type="text" placeholder="Ingrese el nombre de Usuario hasta 10 caracteres" maxlength="10" class="form-control"  required>

                </div>

                <div class="form-group">

                    <input name="nuevoPassword" type="password" placeholder="Ingrese la Contraseña hasta 10 caracteres" maxlength="10" class="form-control" required>

                </div>

                <div class="form-group">

                    <input name="nuevoEmail" type="email" placeholder="Ingrese el Correo Electrónico" class="form-control" required>

                </div>

                <div class="form-group">

                    <select name="nuevoRol" class="form-control" required>

                        <option value="">Seleccione el Rol</option>
                        <option value="0">Administrador</option>
                        <option value="1">Editor</option>

                    </select>

                </div>

                <div class="form-group text-center">
                    
                    <input type="file" class="btn btn-default" id="subirFotoPerfil" style="display:inline-block; margin:10px 0">

                    <p class="text-center" style="font-size:12px">Tamaño recomendado de la imagen: 100px * 100px, peso máximo 2MB</p>

                </div>

                <input type="submit" id="guardarPerfil" value="Guardar Perfil" class="btn btn-primary">

            </form>';


        $crearPerfil = new GestorPerfiles();
        $crearPerfil -> guardarPerfilController();
        $crearPerfil -> editarPerfilController();

    }

?>

    <hr>

    <div class="table-responsive">

    <table id="tablaSuscriptores" class="table table-striped display">
    <thead>
        <tr>
        <th>Usuario</th>
        <th>Perfil</th>
        <th>Email</th>
        <th></th>
        </tr>
    </thead>
    <tbody>

    <?php
        $verPerfil = new GestorPerfiles();
        $verPerfil -> verPerfilesController();
        $verPerfil -> borrarPerfilController();

    ?>
    </tbody>
    </table>

    </div>
</div>

			<!--====  Fin de PERFIL  ====-->