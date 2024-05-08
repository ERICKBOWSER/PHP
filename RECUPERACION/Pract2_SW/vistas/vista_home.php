<?php
if(isset($_POST["btnEntrar"]))
{
    $error_usuario=$_POST["usuario"]=="";
    $error_clave=$_POST["clave"]=="";
    $error_form=$error_usuario||$error_clave;
    if(!$error_form)
    {
        $datos_env=$_POST['usuario']=='';
        $datos_env=$_POST['clave']=='';
        $respuesta=consumir_servicios_REST(DIR_SERV."/login", "POST", $datos_env);
        $json=json_decode($respuesta, true);

        if(!$json){
            session_destroy();
            die(error_page("Práctica Rec 2b","<h1>librería</h1><p>Sin respuesta oportuna de la API. Error:".$e->getMessage()."</p>"));
        }

        if(isset($json("error_bd"))){
            session_destroy();
            die(error_page("Práctica Rec 2b","<h1>librería</h1><p>Error:".$json['error_bd'] ."</p>"));        
        }
        
        if(isset($json['usuario']))
        {          
            $_SESSION["usuario"]=$json['usuario']['usuario'];
            $_SESSION["clave"]=$json['usuario']['clave'];
            $_SESSION["ultm_accion"]=time();
            $_SESSION["api_key"] = $json['api_key'];
            header("Location:index.php");
            exit();
        }
        else
        {
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