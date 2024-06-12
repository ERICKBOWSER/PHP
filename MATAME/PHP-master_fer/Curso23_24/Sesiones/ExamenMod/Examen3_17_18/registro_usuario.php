<?php
require "src/func_ctes.php";

if(isset($_POST["btnVolver"]))
{
    header("Location:index.php");
    exit;
}

if(isset($_POST["btnContRegistro"]))
{
    $error_usuario=$_POST["usuario"]=="" || strlen($_POST["usuario"])>15;
    if(!$error_usuario)
    {
        try{
            $conexion=mysqli_connect(SERVIDOR_BD,USUARIO_BD,CLAVE_BD,NOMBRE_BD);
            mysqli_set_charset($conexion,"utf8");
        }
        catch(Exception $e)
        {
            session_destroy();
            die(error_page("Examen3 Curso 17-18","<h1>Vídeo Club</h1><p>No se ha podido conectar a la BD: ".$error_usuario."</p>"));
        }
        $error_usuario=repetido($conexion,"usuarios","usuario",$_POST["usuario"]);
        
        if(is_string($error_usuario))
        {
            mysqli_close($conexion);
            die(error_page("Examen3 Curso 17-18","<h1>Vídeo Club</h1><p>No se ha podido realizar la consulta: ".$error_usuario."</p>"));
        }
    }
    $error_clave=$_POST["clave"]=="" || strlen($_POST["clave"])>15 || $_POST["clave"]!=$_POST["clave2"];
    $dni_may=strtoupper($_POST["dni"]);
    $error_dni=$_POST["dni"]=="" || !dni_bien_escrito($dni_may) || !dni_valido($dni_may);
    if(!$error_dni)
    {
        if(!isset($conexion))
        {
            try{
                $conexion=mysqli_connect(SERVIDOR_BD,USUARIO_BD,CLAVE_BD,NOMBRE_BD);
                mysqli_set_charset($conexion,"utf8");
            }
            catch(Exception $e)
            {
                session_destroy();
                die(error_page("Examen3 Curso 17-18","<h1>Vídeo Club</h1><p>No se ha podido conectar a la BD: ".$error_usuario."</p>"));
            }
        }

        $error_dni=repetido($conexion,"usuarios","dni",$dni_may);
        
        if(is_string($error_dni))
        {
            mysqli_close($conexion);
            die(error_page("Examen3 Curso 17-18","<h1>Vídeo Club</h1><p>No se ha podido realizar la consulta: ".$error_usuario."</p>"));
        }
    }
    $error_email=$_POST["email"]=="" || strlen($_POST["email"])>15 || !filter_var($_POST["email"], FILTER_VALIDATE_EMAIL);
    if(!$error_email)
    {
        if(!isset($conexion))
        {
            try{
                $conexion=mysqli_connect(SERVIDOR_BD,USUARIO_BD,CLAVE_BD,NOMBRE_BD);
                mysqli_set_charset($conexion,"utf8");
            }
            catch(Exception $e)
            {
                session_destroy();
                die(error_page("Examen3 Curso 17-18","<h1>Vídeo Club</h1><p>No se ha podido conectar a la BD: ".$error_usuario."</p>"));
            }
        }

        $error_email=repetido($conexion,"usuarios","email",$_POST["email"]);
        
        if(is_string($error_email))
        {
            mysqli_close($conexion);
            die(error_page("Examen3 Curso 17-18","<h1>Vídeo Club</h1><p>No se ha podido realizar la consulta: ".$error_usuario."</p>"));
        }
    }
    $error_telefono=$_POST["telefono"]==""  || !is_numeric($_POST["telefono"]) || strlen($_POST["telefono"])>9;

    $error_form=$error_usuario || $error_clave || $error_dni || $error_email || $error_telefono;

    if(!$error_form)//No hay errores en el formulario
    {
        try{
            $consulta="insert into usuarios (DNI, usuario, clave, telefono, email) values('".$dni_may."','".$_POST["usuario"]."','".md5($_POST["clave"])."','".$_POST["telefono"]."','".$_POST["email"]."')";
            mysqli_query($conexion, $consulta);
         }
         catch(Exception $e)
         {
            
             mysqli_close($conexion);
             die(error_page("Examen3 Curso 17-18","<h1>Video Club</h1><p>No se ha podido realizar la consulta: ".$e->getMessage()."</p>"));
         }

        session_name("Examen3_17_18");
        session_start();
        $_SESSION["usuario"]=$_POST["usuario"];
        $_SESSION["clave"]=md5($_POST["clave"]);
        $_SESSION["ultima_accion"]=time();
        mysqli_close($conexion);
        header("Location:index.php");
        exit;

    }
    
    if(isset($conexion))
    {
        mysqli_close($conexion);
    }
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examen3 Curso 17-18</title>
    <style>
        .error{color:red}
    </style>
</head>
<body>
    <h1>Vídeo Club</h1>
    <form action="registro_usuario.php" method="post">
        <p>
            <label for="usuario">Usuario: </label>
            <input type="text" name="usuario" id="usuario" maxlength="15" value="<?php if(isset($_POST["usuario"])) echo $_POST["usuario"];?>"/>
            <?php
            if(isset($_POST["btnContRegistro"])&& $error_usuario)
            {
                if($_POST["usuario"]=="")
                    echo "<span class='error'> Campo vacío </span>";
                elseif(strlen($_POST["usuario"])>15)
                    echo "<span class='error'> Has tecleado más de 15 caracteres</span>";
                else
                    echo "<span class='error'> Usuario repetido</span>";
            }
                
            ?>
        </p>
        <p>
            <label for="clave">Contraseña: </label>
            <input type="password" name="clave" id="clave" maxlength="15"/>
            <?php
            if(isset($_POST["btnContRegistro"])&& $error_clave)
            {
                if($_POST["clave"]=="")
                    echo "<span class='error'> Campo vacío </span>";
                elseif(strlen($_POST["clave"])>15)
                    echo "<span class='error'> Has tecleado más de 15 caracteres</span>";
                else
                    echo "<span class='error'> No has repetido bien la contraseña</span>";
            }
            ?>
        </p>
        <p>
            <label for="clave2">Repita Contraseña:</label>
            <input type="password" name="clave2" id="clave2" maxlength="15"/>
        </p>
        <p>
            <label for="dni">DNI:</label>
            <input type="text" placeholder="DNI: 11223344Z" maxlength="9" name="dni" id="dni" value="<?php if(isset($_POST["dni"])) echo $_POST["dni"];?>"/>
            <?php
            if(isset($_POST["btnContRegistro"])&& $error_dni)
            {
                if($_POST["dni"]=="")
                    echo "<span class='error'> Campo vacío </span>";
                elseif(!dni_bien_escrito($dni_may))
                    echo "<span class='error'> DNI no está bien escrito </span>";
                elseif(!dni_valido($dni_may))
                    echo "<span class='error'> DNI no válido </span>";
                else
                    echo "<span class='error'> DNI repetido </span>";
            }
                
            ?>
        </p>
        <p>
            <label for="email">Email: </label>
            <input type="text" name="email" id="email" maxlength="15" value="<?php if(isset($_POST["email"])) echo $_POST["email"];?>"/>
            <?php
            if(isset($_POST["btnContRegistro"])&& $error_email)
            {
                if($_POST["email"]=="")
                    echo "<span class='error'> Campo vacío </span>";
                elseif(strlen($_POST["email"])>15)
                    echo "<span class='error'> Has tecleado más de 15 caracteres</span>";
                elseif(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL))
                    echo "<span class='error'> Email sintácticamente incorrecto</span>";
                else
                    echo "<span class='error'> Email repetido</span>";
            }
                
            ?>
        </p>
        <p>
            <label for="telefono">Telefono: </label>
            <input type="text" name="telefono" id="telefono" maxlength="9" value="<?php if(isset($_POST["telefono"])) echo $_POST["telefono"];?>"/>
            <?php
            if(isset($_POST["btnContRegistro"])&& $error_telefono)
            {
                if($_POST["telefono"]=="")
                    echo "<span class='error'> Campo vacío </span>";
                elseif(!is_numeric($_POST["telefono"]))
                    echo "<span class='error'> No has tecleado un número</span>";
                else
                    echo "<span class='error'> Has tecleado un número de más de 9 dígitos</span>";
      
            }
                
            ?>
        </p>
        <p>
            <button type="submit" name="btnVolver">Volver</button> 
            <button type="submit" name="btnContRegistro">Continuar</button>
        </p>
    </form>
</body>
</html>