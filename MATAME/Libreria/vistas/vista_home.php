<?php
if(isset($_POST["btnEntrar"]))
{
    $error_usuario=$_POST["usuario"]=="";
    $error_clave=$_POST["clave"]=="";
    $error_form=$error_usuario||$error_clave;
    if(!$error_form)
    {
        try{
            $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'")); 
        }
        catch(PDOException $e){
            session_destroy();
            die(error_page("Práctica Rec 2b","<h1>librería</h1><p>Imposible conectar a la BD. Error:".$e->getMessage()."</p>"));
        }
    
        try{
            $datos[0]=$_POST["usuario"];
            $datos[1]=md5($_POST["clave"]);
            $consulta = "SELECT * FROM usuarios WHERE lector=? AND clave=?";
            $sentencia=$conexion->prepare($consulta);
            $sentencia->execute($datos);
        }
        catch(PDOException $e){
            $sentencia=null;
            $conexion=null;
            session_destroy();
            die(error_page("Práctica Rec 2b","<h1>librería</h1><p>Imposible realizar la consulta. Error:".$e->getMessage()."</p>"));
        }

        if($sentencia->rowCount()>0)
        {
            $datos_usu=$sentencia->fetch(PDO::FETCH_ASSOC);
            $sentencia=null;
            $conexion=null;
            $_SESSION["usuario"]=$datos[0];
            $_SESSION["clave"]=$datos[1];
            $_SESSION["ultm_accion"]=time();
            if($datos_usu["tipo"]=="normal")
                header("Location:index.php");
            else
                header("Location:admin/gest_libros.php");

            exit();
        }
        else
        {
            $sentencia=null;
            $conexion=null;
            $error_usuario=true;
        }
    }
}

///Consulta para traerse los libros


?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Práctica Rec 2b</title>
    <style>
        .error{color:red}
        .mensaje{color:blue;font-size:1.25em}
    </style>
</head>
<body>
    <h1>Librería</h1>
    <form action="index.php" method="post">
        <p>
            <label for="usuario">Usuario: </label>
            <input type="text" name="usuario" id="usuario" value="<?php if(isset($_POST["usuario"])) echo $_POST["usuario"];?>">
            <?php
            if(isset($_POST["btnEntrar"])&& $error_usuario)
            {
                if($_POST["usuario"]=="")
                    echo "<span class='error'> Campo vacío</span>";
                else
                    echo "<span class='error'> Usuario y/o Contraseña no válidos</span>";
            }
                
            ?>
        </p>
        <p>
            <label for="clave">Contraseña: </label>
            <input type="password" name="clave" id="clave">
            <?php
            if(isset($_POST["btnEntrar"])&& $error_clave)
                echo "<span class='error'> Campo vacío</span>";
            ?>
        </p>
        <p>
            <button type="submit" name="btnEntrar">Entrar</button> 
        </p>
    </form>
    <?php
    if(isset($_SESSION["seguridad"]))
    {
        echo "<p class='mensaje'>".$_SESSION["seguridad"]."</p>";
        session_destroy();
    }

    ?>
    <h2>Listado de Libros</h2>
    <!-- Aquí se mostrarían los libros de tres en tres -->
</body>
</html>