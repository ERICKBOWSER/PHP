<?php
 echo "<h2>Detalles del usuario con id:".$id_usuario."</h2>";
 if(!isset($usuario))
 {
     echo "<p>El usuario seleccionado ya no se encuentra en la BD</p>";
 }
 else
 {
     //Por aquí el formulario de edición
 ?>
     <form action="index.php" method="post" enctype="multipart/form-data">
         <table id="t_editar" class='sin_bordes'>
         <tr>
         <td>
         <p>
             <label for="usuario">Usuario: </label><br>
             <input type="text" id="usuario" name="usuario" value="<?php echo $usuario;?>" placeholder="Usuario...">
             <?php
             if((isset($_POST["btnContEditar"]) || isset($_POST["btnBorrarFoto"]) || isset($_POST["btnNoBorrarFoto"]) )&& $error_usuario)
             {
                 if($_POST["usuario"]=="")
                     echo "<span class='error'> Campo vacío</span>";
                 else
                     echo "<span class='error'> Usuario repetido</span>";
             }
                 
             ?>
         </p>
         <p>
             <label for="nombre">Nombre: </label><br>
             <input type="text" id="nombre" name="nombre" value="<?php echo $nombre;?>" placeholder="Nombre...">
             <?php
             if((isset($_POST["btnContEditar"]) || isset($_POST["btnBorrarFoto"]) || isset($_POST["btnNoBorrarFoto"]) )&& $error_nombre)
                 echo "<span class='error'> Campo vacío</span>";
             ?>
         </p>
         <p>
             <label for="clave">Contraseña: </label><br>
             <input type="password" id="clave" name="clave" placeholder="Teclee nueva contraseña...">
         </p>
         <p>
             <label for="dni">DNI: </label><br>
             <input type="text" id="dni" name="dni" value="<?php echo $dni;?>" placeholder="DNI: 11223344Z">
             <?php
             if((isset($_POST["btnContEditar"]) || isset($_POST["btnBorrarFoto"]) || isset($_POST["btnNoBorrarFoto"]) )&& $error_dni)
             {
                 if($_POST["dni"]=="")
                     echo "<span class='error'> Campo vacío</span>";
                 else if(!dni_bien_escrito($_POST["dni"]))
                     echo "<span class='error'> DNI no está bien escrito</span>";
                 else if(!dni_valido($_POST["dni"]))
                     echo "<span class='error'> DNI no es válido</span>";
                 else
                     echo "<span class='error'> DNI repetido</span>";
             }
             ?>
         </p>
         <p>
             <label>Sexo: </label><br>
             <input type="radio" id="hombre" name="sexo" value="hombre" <?php if($sexo=="hombre") echo "checked";?>>
             <label for="hombre">Hombre: </label><br>
             <input type="radio" id="mujer" name="sexo" value="mujer" <?php if($sexo=="mujer") echo "checked";?>>
             <label for="mujer">Mujer: </label><br>
         </p>
         <p>
             <label for="foto">Cambiar la foto (Máx. 500 KB)</label>
             <input type="file" name="foto" id="foto" accept="image/*">
             <?php
             if((isset($_POST["btnContEditar"]) || isset($_POST["btnBorrarFoto"]) || isset($_POST["btnNoBorrarFoto"]) )&& $error_foto)
             {
                 if($_FILES["foto"]["error"])
                     echo "<span class='error'> Error en la subida del fichero al servidor </span>";
                 else if (!explode(".",$_FILES["foto"]["name"]))
                     echo "<span class='error'> El fichero subido debe tener extensión </span>";
                 else if (! getimagesize($_FILES["foto"]["tmp_name"]))
                     echo "<span class='error'> El fichero subido debe ser una imagen</span>";
                 else
                     echo "<span class='error'> El tamaño del fichero no debe superar los 500 KB</span>";
             }
             ?>
         </p>
         <p>
             <input type="checkbox" id="subsc" name="subscripcion" <?php if($subscripcion) echo "checked";?>>
             <label for="subsc">Suscribirme al boletín de novedades: </label><br>
         </p>
         
         <p>
             <input type="hidden" name="foto_bd" value='<?php echo $foto;?>'>
             <input type="hidden" name="id_usuario" value='<?php echo $id_usuario;?>'>
             <button type="submit" name="btnContEditar">Guardar Cambios</button>
             <button type="submit" name="btnBorrarEditar">Borrar los datos introducidos</button>
         </p>
         </td>
         <td>
             <p class='centrado'>
                 <img class='img_editar' src='images/<?php echo $foto;?>' title='Foto' alt='Foto'>
             
             <?php
             if(isset($_POST["btnBorrarFoto"]))
             {
                 echo "<br>¿Estás seguro?<br>";
                 echo "<button type='submit' name='btnContBorrarFoto'>Sí</button> <button type='submit' name='btnNoBorrarFoto'>No</button>";
             }
             elseif($foto!=FOTO_DEFECTO)
             {
                 echo "<br><button name='btnBorrarFoto' type='submit'>Borrar Foto</button>";
             }
             ?>
             </p>
         </td>
         </tr>
         </table>
     </form>

 <?php
 }
?>