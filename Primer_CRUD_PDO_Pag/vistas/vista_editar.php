<?php
if(isset($_POST["btnEditar"]))
 $id_usuario=$_POST["btnEditar"];
else
 $id_usuario=$_POST["btnContEditar"];


try{
        
    $consulta="select * from usuarios where id_usuario=?";
    $sentencia=$conexion->prepare($consulta);
    $sentencia->execute([$id_usuario]);
}
catch(PDOException $e)
{
    $sentencia=null;
    $conexion=null;
    session_destroy();
    die("<p>No se ha podido realizar la consulta: ".$e->getMessage()."</p></body></html>");
}

if($sentencia->rowCount()>0)
{
 if(isset($_POST["btnEditar"]))
 {    //Recojo datos obtenidos de la BD
     $datos_usuario=$sentencia->fetch(PDO::FETCH_ASSOC);
     $nombre=$datos_usuario["nombre"];
     $usuario=$datos_usuario["usuario"];
     //$clave=$datos_usuario["clave"];
     $email=$datos_usuario["email"];
     
 }
 else
 {
     $nombre=$_POST["nombre"];
     $usuario=$_POST["usuario"];
     //$clave=$datos_usuario["clave"];
     $email=$_POST["email"];
 }
 $sentencia=null;
}
else
{
 $mensaje_error_usuario="<p>El usuario seleccionado ya no se encuentra registrado en la BD</p>";
}

if(isset($mensaje_error_usuario))
 echo $mensaje_error_usuario;
else
{
?>
 <h2>Editando al usuario <?php echo $id_usuario;?></h2>
 <form action="index.php" method="post">
     <p>
         <label for="nombre">Nombre: </label>
         <input type="text" name="nombre" id="nombre" maxlength="30" value="<?php echo $nombre;?>">
         <?php
         if(isset($_POST["btnContEditar"]) && $error_nombre)
         {
             if($_POST["nombre"]=="")
                 echo "<span class='error'> Campo vacío</span>";
             else
                 echo "<span class='error'> Has tecleado más de 30 caracteres</span>";
         }
         ?>
     </p>
     <p>
         <label for="usuario">Usuario: </label>
         <input type="text" name="usuario" id="usuario" maxlength="20" value="<?php echo $usuario;?>" >
         <?php
         if(isset($_POST["btnContEditar"]) && $error_usuario)
         {
             if($_POST["usuario"]=="")
                 echo "<span class='error'> Campo vacío</span>";
             elseif(strlen($_POST["usuario"])>20)
                 echo "<span class='error'> Has tecleado más de 20 caracteres</span>";
             else
                 echo "<span class='error'> Usuario repetido</span>";
         }
         ?>
     </p>
     <p>
         <label for="clave">Contraseña: </label>
         <input type="password" name="clave" maxlength="15" id="clave" placeholder="Editar contraseña">
         <?php
         if(isset($_POST["btnContEditar"]) && $error_clave)
         {
                 echo "<span class='error'> Has tecleado más de 15 caracteres</span>";
         }
         ?>
     </p>
     <p>
         <label for="email">Email: </label>
         <input type="text" name="email" id="email" maxlength="50" value="<?php echo $email;?>">
         <?php
         if(isset($_POST["btnContEditar"]) && $error_email)
         {
             if($_POST["email"]=="")
                 echo "<span class='error'> Campo vacío</span>";
             elseif(strlen($_POST["email"])>50)
                 echo "<span class='error'> Has tecleado más de 50 caracteres</span>";
             elseif(!filter_var($_POST["email"],FILTER_VALIDATE_EMAIL))
                 echo "<span class='error'> Email sintáxticamente incorrecto</span>";
             else
                 echo "<span class='error'> Email repetido</span>";
         }
         ?>
     </p>
     <p>
         <button type="submit" name="btnContEditar" value="<?php echo $id_usuario;?>">Continuar</button> 
         <button type="submit">Volver</button> 
     </p>
 </form>


<?php
}

?>