<?php
if (isset($_POST["btnLogin"])) {
    
    $errorUsu = $_POST["usuario"] == "";
    $errorClave = $_POST["clave"] == "";

    $errorForm = $errorUsu || $errorClave;

    if(!$errorForm){

        $datos["usuario"] = $_POST["usuario"];
        $datos["clave"] = md5($_POST["clave"]);

        $url = DIR_SERV . "/login";
        $respuesta = consumir_servicios_REST($url,"POST",$datos);
        $obj = json_decode($respuesta);

        if(!$obj){
            session_destroy();
            die(error_page("Error","<p>Obj no creado<p>"));
        }

        if(isset($obj->error)){
            session_destroy();
            die(error_page("Error","<p>Error en la API<p>"));
        }

        if(isset($obj->mensaje)){
            $errorUsu = true;
        }else{
            $_SESSION["usuario"] = $obj->usuario->usuario;
            $_SESSION["clave"] = $obj->usuario->clave;
            $_SESSION["ultConex"] = time();
            $_SESSION["api_session"] = $obj->api_session;
            header("Location:index.php");
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
    <title>Recuperacion</title>
    <style>
        .error{
            color: red;
        }
    </style>
</head>
<body>
    <h1>Gestión de Guardias</h1>
    <form action="index.php" method="post">
        <p>
            <label for="usuario">Usuario: </label>
            <input type="text" name="usuario" id="usuario" value="<?php if(isset($_POST["usuario"])) echo $_POST["usuario"]?>">
            <?php
            if(isset($_POST["btnLogin"]) && $errorUsu){
                if($_POST["usuario"] == ""){
                    echo "<span class='error'>No deje campos vacios</span>";
                }else{
                    echo "<span class='error'>Usuario/Contraseña incorrectos</span>";
                }
            }
            ?>
        </p>
        <p>
            <label for="clave">Contraseña: </label>
            <input type="password" name="clave" id="clave">
            <?php
            if(isset($_POST["btnLogin"]) && $errorClave){
                echo "<span class='error'>No deje campos vacios</span>";
            }
            ?>
        </p>
        <button type="submit" name="btnLogin">Entrar</button>
    </form>
    <?php
    if(isset($_SESSION["seguridad"])){
        echo "<span class='mensaje'>".$_SESSION["seguridad"]."</span>";
        session_destroy();
    }
    ?>
</body>
</html>