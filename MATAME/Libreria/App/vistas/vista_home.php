<?php
if(isset($_POST["btnLogin"])){

    $error_usuario=$_POST["usuario"]=="";
    $error_clave=$_POST["clave"]=="";
    $error_form=$error_usuario || $error_clave;
    if(!$error_form){

        $url=DIR_SERV."/login";
        $datos["usuario"]=$_POST["usuario"];
        $datos["clave"]=$_POST["clave"];

        $respuesta=consumir_servicios_REST($url, "POST", $datos);
        $json=json_decode($respuesta, true);
        if(!$json){
            session_destroy();
            die(error_page("Examen Libreria", "<h1>Libreria</h1><p>Error consumiendo el servicio: ".$url."</p>"));
        }
        if(isset($json["error"])){
            session_destroy();
            die(error_page("Examen Libreria", "<h1>Libreria</h1><p>Error en btnLogin: ".$json["error"]));
        }

        // SI NO HAY FALLOS
        if(isset($json["usuario"])){
            $_SESSION["usuario"]=$json["usuario"]["usuario"];
            $_SESSION["clave"]=$json["usuario"]["clave"];
            $_SESSION["ult_accion"]=time();
            $_SESSION["api_session"]=$json["api_session"];

            if($json["usuario"]["tipo"]=="admin"){
                header("Location:admin/gest_libros.php");
            }else{
                header("Location:index.php");
            }
            
        }else{
            $error_usuario=true;  // SI HAY MENSAJE DE ERROR DEL SERVICIO

        }

    }


   
}




?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Libreria</title>
</head>
<body>
    <form action="index.php" method="post">
        <p>
        <h1>Librería</h1>
        <p>
        <label for="usuario">Usuario: </label>
        <input type="text" name="usuario" id="usuario" value="<?php if(isset($_POST["usuario"])) echo $_POST["usuario"];?>">
        <?php
        if(isset($_POST["btnLogin"]) && $error_usuario){
            if($_POST["usuario"] == ""){
                echo "<span class='error'>Campo vacío</span>";
            }else{
                echo "<span class='error'>Datos incorrectos</span>";
            }
        }
        ?>
        </p>
        <p>
        <label for="clave">Contraseña: </label>
        <input type="password" id="clave" name="clave">
        <?php
        if(isset($_POST["btnLogin"]) && $error_clave){
            if($_POST["clave"]==""){
                echo "<span class='error'>Campo vacío</span>";
            }
        }
        ?>
        </p>
        <button type="submit" name="btnLogin">Entrar</button>
        </p>
    </form>
    <?php
    if(isset($_SESSION["seguridad"])){
        echo "<p class='mensaje'>".$_SESSION["seguridad"]."</p>";
        session_destroy();
    }
    ?>
</body>
</html>