<?php
    if(isset($_POST["btnLogin"])){
        $error_usuario = $_POST["usuario"] == "";
        $error_clave = $_POST["clave"] == "";
        $error_form = $error_usuario || $error_clave;

        if(!$error_form){ // SI NO HAY ERRORES CREAMOS LA SESIÓN PARA EL USUARIO
            $url = DIR_SERV . "/login";
            $datos["usuario"] = $_POST["usuario"];
            $datos["clave"] = md5($_POST["clave"]);
            $respuesta = consumir_servicios_REST($url, "POST", $datos);
            $obj = json_decode($respuesta);

            if(!$obj){
                session_destroy();
                die(error_page("Examen 2", "<h1>Examen 2</h1><p>Error consumiendo en HOME el servicio:" . $url . "</p>"));
            }

            if(isset($obj -> error)){
                session_destroy();
                die(error_page("Examen 2", "<h1>Examen 2</h1><p>" . $obj->error . "</p>"));
            }

            if(isset($obj->mensaje)){
                $error_usuario = true;
            }else{
                $_SESSION["usuario"] = $obj->usuario->usuario;
                $_SESSION["clave"] = $obj->usuario->clave;
                $_SESSION["ult_accion"] = time();

                $_SESSION["api_session"] = $obj->api_session;

                header("Location: index.php");
                exit;
            }

            header("Location: index.php");

        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examen 3</title>
</head>
<body>
    <h1>Examen 3</h1>
    <form method="post" action="index.php">
        <p>
            <label for="usuario">Usuario</label>
            <input type="text" id="usuario" name="usuario" value="<?php if(isset($_POST["usuario"])) echo $_POST["usuario"];?>">
            <?php
                if(isset($_POST["btnLogin"]) && $error_usuario){
                    if($_POST["usuario"] == ""){
                        echo "<span class='error'>Campo vacío</span>";
                    }else{
                        echo "<span class='error'>Usuario/clave incorrectos</span>";
                    }
                }
            ?>
        </p>
        <p>
            <label for="clave">Contraseña</label>
            <input type="password" id="clave" name="clave">
            <?php
                if(isset($_POST["btnLogin"]) && $error_clave){
                    echo "<span class='error'>Campo vacío</span>";
                }
            ?>
        </p>
        <p>
            <button type="submit" name="btnLogin">Login</button>
        </p>
    </form>

    <?php
    if(isset($_SESSION["seguridad"])){
        echo "<p class='mensaje'>" . $_SESSION["seguridad"] . "</p>";
        session_destroy();
    }

    require "vista_horarios.php";
    //header("Location:index.php"); NO SE PUEDE COLOCAR YA QUE SALE ALERTA DE QUE SE HA REDIRIGIDO MUCHAS VECES

    ?>
    
</body>
</html>