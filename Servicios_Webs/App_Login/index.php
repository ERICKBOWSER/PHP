<?php
    session_name("AppLogin_2324");
    session_start();

    require "src/funciones_ctes.php";

    if(isset($_POST["btnSalir"])){
        session_destroy();
        header("Location:index.php");
        exit;
    }

    if(isset($_SESSION["usuario"])){
        require "src/seguridad.php";
        
        if($datosUsuarioLog->tipo == "normal"){
            require "vistas/vista_normal.php";
        }else{
            require "vistas/vista_admin.php";
        }

    }else{
        if(isset($_POST["btnLogin"])){
            $usuario = $_POST["usuario"]=="";
            $clave = $_POST["clave"] == "";
            $error_form = $errorUsuario || $errorClave;
            if(!$error_form){
                $datos["usuario"] = $_POST["usuario"];
                $datos["clave"] = md5($_POST["clave"]);
                $url = DIR_SERV . "/login";
                $respuesta = consumir_servicios_REST($url, "POST", $datos);
                $obj =json_decode($respuesta);
                if(!$obj){
                    session_destroy();
                    die(errorPage("App Login SW", "<h1>App Login SW</h1>" . $respuesta));
                }

                if(isset($obj->mensaje_error)){
                    session_destroy();
                    die(errorPage("App Login SW", "<h1>App Login SW</h1><p>" . $obj->mensaje_error . "</p>"));
                }

                // SI EXISTE $OBJ EL USUARIO ESTA LOGUEADO
                if(isset($obj->mensaje)){
                    $error_usuario = true;
                }else{
                    $_SESSION["usuario"] = $obj->usuario->usuario;
                    $_SESSION["clave"] = $obj->usuario->clave;
                    $_SESSION["ult_accion"]=time();

                    header("Location:index.php");
                    exit;
                }
            }
        }
    } 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>App Login SW</title>
</head>
<body>
    <h1>App Login SW</h1>
    <form action="index.php" method="post">
        <p>
            <label for="usuario">Usuario: </label>
            <input type="text" name="usuario" id="usuario" value="<?php if(isset($_POST["usuario"])) echo $_POST["usuario"];?>">
            <?php
                if(isset($_POST["btnLogin"]) && $errorUsuario){
                    if($_POST["usuario"] == ""){
                        echo "<span class='error'>Campo vacío</span>";
                    }else{
                        echo "<spam class='error'>Usuario/clave no validos</span>";
                    }
                }
            ?>
        </p>

        <p>
            <label for="clave">Contraseña: </label>
            <input type="text" name="clave" id="clave" value="">
            <?php
                if(isset($_POST["btnLogin"]) && $errorUsuario){
                    echo "<span class='error'>Campo vacío</span>";
                }
            ?>
        </p>

        <p>
            <button type="submit" name="btnLogin" id="btnLogin" value="">Login</button>
        </p>  
    </form>
    <?php
    if(isset($_SESSION["seguridad"])){
        echo "<p class='mensaje'>" . $_SESSION["seguridad"] . "</p>";

        session_destroy();
    }
    ?>
</body>
</html>


<?php


?>