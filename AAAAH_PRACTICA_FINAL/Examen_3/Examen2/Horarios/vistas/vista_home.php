<?php
    if(isset($_POST["btnLogin"])){
        // 1ro comprobar que no hay errores en el formulario
        $errorUsuario = $_POST["usuario"] == "";
        $errorClave = $_POST["clave"] == "";
        $errorForm = $errorUsuario || $errorClave;

        if(!$errorForm){
            // COMPROBAMOS SI EL USUARIO EXISTE Y SI EXISTE CREAMOS UNA SESION
            $url = DIR_SERV . "/login";
            $datos["usuario"] = $_POST["usuario"];
            $datos["clave"] = md5($_POST["clave"]);
            $respuesta = consumir_servicios_REST($url, "POST", $datos);
            $obj = json_decode($respuesta);
            if(!$obj){
                session_destroy();
                die(errorPage("Examen2", "<h1>Examen2</h1><p>Error consumiendo el servicio: " . $url . "</p>"));
            }

            if(isset($obj->error)){
                session_destroy();
                die(errorPage("Examen2", "<h1>Examen2</h1><p>" . $obj->error . "</p>"));
            }

            if(isset($obj-> mensaje)){
                $errorUsuario = true;
            }else{
                $_SESSION["usuario"] = $obj->usuario->usuario;
                $_SESSION["clave"] = $obj->usuario->clave;
                $_SESSION["ult_accion"] = time();

                $_SESSION["api_session"] = $obj->api_session;

                header("Location: index.php");
                exit;

            }
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Librería</title>
    <style>
        .error{
            color:red
        }
        .mensaje{
            color: blue;
        }
    </style>
</head>
<body>
    <h1>Examen2</h1>
    <form method="post" action="index.php">
        <p>
            <label for="">Usuario</label>
            <input type="text" name="usuario" id="usuario" value="<?php if(isset($_POST["usuario"])) echo $_POST["usuario"] ?>"/> <!-- SI EL USUARIO HA SIDO ENVIADO MUESTRALO-->
            <?php
            if(isset($_POST["btnLogin"]) && $errorUsuario){
                if(isset($_POST["btnLogin"]) && $errorUsuario){
                    if($_POST["usuario"] == ""){
                        echo "<span class='error'>Campo vacío</span>";
                    }else{
                        echo "<span class='error'>Usuario/Clave incorrectos</span>";
                    }
                }

                echo "<span class='error'>Campo vacío</span>";
            }
            ?>
        </p>
        <p>
            <label for="clave">Contraseña:</label>
            <input type="password" name="clave" id="clave"/>
            <?php
            if(isset($_POST["btnLogin"]) && $errorClave){
                echo "<span class='error'>Campo vacío</span>";
            }
            ?>
        </p>
        <p>
            <button name="btnEntrar">Entrar</button>
        </p>      
    </form>        

</body>
</html>