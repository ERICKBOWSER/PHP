<?php

if(isset($_POST["btnBorrar"]))
{
    unset($_POST);
}



if(isset($_POST["btnEnviar"]))
{
    //compruebo los errores

    $error_nombre=$_POST["nombre"]=="";
    $error_usuario=$_POST["usuario"]=="";
    if(!$error_usuario)
    {
        try{
            $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'")); 
        }
        catch(PDOException $e){
            session_destroy();
            die(error_page("Práctica Rec 2","<h1>Práctica Rec 2</h1><p>Imposible conectar a la BD. Error:".$e->getMessage()."</p>"));
        }
        $error_usuario=repetido($conexion,"usuarios","usuario",$_POST["usuario"]);
        if(is_string($error_usuario))
        {
            $conexion=null;
            session_destroy();
            die(error_page("Práctica Rec 2","<h1>Práctica Rec 2</h1><p>".$error_usuario."</p>"));
        }
    }
    $error_clave=$_POST["clave"]=="";
    $error_dni=$_POST["dni"]=="" || !dni_bien_escrito($_POST["dni"]) || !dni_valido($_POST["dni"]);
    if(!$error_dni)
    {
        if(!isset($conexion))
        {
            try{
                $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'")); 
            }
            catch(PDOException $e){
                session_destroy();
                die(error_page("Práctica Rec 2","<h1>Práctica Rec 2</h1><p>Imposible conectar a la BD. Error:".$e->getMessage()."</p>"));
            }
        }
        $error_dni=repetido($conexion,"usuarios","dni",strtoupper($_POST["dni"]));
        if(is_string($error_dni))
        {
            $conexion=null;
            session_destroy();
            die(error_page("Práctica Rec 2","<h1>Práctica Rec 2</h1><p>".$error_dni."</p>"));
        }
    }
 
    $error_foto=$_FILES["foto"]["name"]!="" && ($_FILES["foto"]["error"] || !explode(".", $_FILES["foto"]["name"])|| !getimagesize($_FILES["foto"]["tmp_name"] ) || $_FILES["foto"]["size"]>500*1024);//Foto no obligatoria
    //$error_foto=$_FILES["foto"]["name"]=="" || $_FILES["foto"]["error"] || !explode(".", $_FILES["foto"]["name"])|| !getimagesize($_FILES["foto"]["tmp_name"] ) || $_FILES["foto"]["size"]>500*1024;//Foto obligatoria
    $error_form=$error_nombre|| $error_usuario || $error_clave || $error_dni || $error_foto;
   
    if(!$error_form)
    {

        try{
            if(isset($_POST["subscripcion"]))
                $subs=1;
            else
                $subs=0;

            $consulta = "insert into usuarios (usuario,nombre,clave,dni,sexo,subscripcion) values (?,?,?,?,?,?)";
            $sentencia=$conexion->prepare($consulta);
            $sentencia->execute([$_POST["usuario"],$_POST["nombre"],md5($_POST["clave"]),strtoupper($_POST["dni"]),$_POST["sexo"],$subs]);
            $sentencia=null;
          
        }
        catch(PDOException $e){
            $setencia=null;
            $conexion=null;
            session_destroy();
            die(error_page("Práctica Rec 2","<h1>Práctica Rec 2</h1><p>Imposible realizar la consulta. Error:".$e->getMessage()."</p>"));
        }
       
        $mensaje="Se ha registrado con éxito";

        if($_FILES["foto"]["name"]!="")
        {
            $ultm_id=$conexion->lastInsertId();
            $array_ext=explode(".", $_FILES["foto"]["name"]);
            $ext=".".end($array_ext);
            $nombre_nuevo="img_".$ultm_id.$ext;
            @$var=move_uploaded_file($_FILES["foto"]["tmp_name"],"images/".$nombre_nuevo);
            if($var)
            {
                try{
                  
                    $consulta = "update usuarios set foto=? where id_usuario=?";
                    $sentencia=$conexion->prepare($consulta);
                    $sentencia->execute([$nombre_nuevo, $ultm_id]);
                    $sentencia=null;
                  
                }
                catch(PDOException $e){
                    unlink("images/".$nombre_nuevo);
                    $sentencia=null;
                    $conexion=null;
                    $mensaje="Se ha registrado con éxito pero con la imagen por defecto por un problema en la BD del servidor";
                }
            }
            else
            {
                $mensaje="Se ha registrado con éxito pero con la imagen por defecto ya que no se ha podido mover la imagen a la carpeta destino en el servidor";
            }
          
        }

        $conexion=null;
        $_SESSION["mensaje_registro"]=$mensaje;
        $_SESSION["usuario"]=$_POST["usuario"];
        $_SESSION["clave"]=md5($_POST["clave"]);
        $_SESSION["ultm_accion"]=time();
        header("Location:index.php");
        exit();
    }


    if(isset($conexion))
        $conexion=null;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Práctica Rec 2</title>
    <style>
        .error{color:red}
    </style>
</head>
<body>
<h1>Práctica Rec 2</h1>
    <form action="index.php" method="post" enctype="multipart/form-data">
        <p>
            <label for="usuario">Usuario: </label><br>
            <input type="text" id="usuario" name="usuario" value="<?php if(isset($_POST["usuario"])) echo $_POST["usuario"];?>" placeholder="Usuario...">
            <?php
            if(isset($_POST["btnEnviar"])&& $error_usuario)
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
            <input type="text" id="nombre" name="nombre" value="<?php if(isset($_POST["nombre"])) echo $_POST["nombre"];?>" placeholder="Nombre...">
            <?php
            if(isset($_POST["btnEnviar"])&& $error_nombre)
                echo "<span class='error'> Campo vacío</span>";
            ?>
        </p>
        <p>
            <label for="clave">Contraseña: </label><br>
            <input type="password" id="clave" name="clave" placeholder="Contraseña...">
            <?php
            if(isset($_POST["btnEnviar"])&& $error_clave)
                echo "<span class='error'> Campo vacío</span>";
            ?>
        </p>
        <p>
            <label for="dni">DNI: </label><br>
            <input type="text" id="dni" name="dni" value="<?php if(isset($_POST["dni"])) echo $_POST["dni"];?>" placeholder="DNI: 11223344Z">
            <?php
            if(isset($_POST["btnEnviar"])&& $error_dni)
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
            <input type="radio" id="hombre" name="sexo" value="hombre" <?php if(!isset($_POST["sexo"]) || (isset($_POST["sexo"]) && $_POST["sexo"]=="hombre")) echo "checked";?>>
            <label for="hombre">Hombre: </label><br>
            <input type="radio" id="mujer" name="sexo" value="mujer" <?php if(isset($_POST["sexo"]) && $_POST["sexo"]=="mujer") echo "checked";?>>
            <label for="mujer">Mujer: </label><br>
        </p>
        <p>
            <label for="foto">Incluir mi foto (Máx. 500 KB)</label>
            <input type="file" name="foto" id="foto" accept="image/*">
            <?php
            if(isset($_POST["btnEnviar"])&& $error_foto)
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
            <input type="checkbox" id="subsc" name="subscripcion" <?php if(isset($_POST["subscripcion"])) echo "checked";?>>
            <label for="subsc">Suscribirme al boletín de novedades: </label><br>
        </p>
        <p>
            <button type="submit" name="btnEnviar">Guardar Cambios</button>
            <button type="submit" name="btnBorrar">Borrar los datos introducidos</button>
        </p>
    </form>
</body>
</html>