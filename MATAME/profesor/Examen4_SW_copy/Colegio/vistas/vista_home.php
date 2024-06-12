<?php
if(isset($_POST["btnLogin"])){
    $error_usuario=$_POST["usuario"] == "";
    $error_clave=$_POST["clave"] == "";
    $error_form = $error_usuario || $error_clave;
    if(!$error_form){
        $url=DIR_SERV."/login";
        $datos["usuario"]=$_POST["usuario"];
        $datos["clave"]=md5($_POST["clave"]);
        $respuesta=consumir_servicios_REST($url, "POST", $datos);
        $json=json_decode($respuesta, true);
        if(!$json){
            session_destroy();
            die(error_page("Examen 4", "<h1>Notas de los alumnos</h1><p>Error consumiendo el servicio ".$url."</p>"));
        }

        if(isset($json["error"])){
            session_destroy();
            die(error_page("Examen 4", "<h1>Notas de los alumnos</h1><p>".$json["error"]."</p>"));
        }

        if(isset($json["mensaje"])){
            $error_usuario=true;
        }else{
            $_SESSION["usuario"]=$json["usuario"]["usuario"];
            $_SESSION["clave"]=$json["usuario"]["clave"];
            $_SESSION["ult_accion"]=time();
            $_SESSION["api_session"]=$json["api_session"];

            if($json["usuario"]["tipo"]=="tutor"){
                header("Location:admin/index.php");
            }else{
                header("Location:index.php");
            }
            exit();
        }
    }
}




?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        
        .error{
            color:red
        }
        .mensaje{
            color:blue;
            font-size:1.25em;
        }
    </style>
</head>
<body>
    <h1>Notas de los alumnos</h1>
    <form action="index.php" method="post">
        <p>
            <label for="usuario">Usuario: </label>
            <input type="text" id="usuario" name="usuario" value="<?php if(isset($_POST["usuario"])) echo $_POST["usuario"];?>">
            <?php
            if(isset($_POST["btnLogin"]) && $error_usuario){
                if($_POST["usaurio"]==""){
                    echo "<span class='error'> Campo Vacío</span>";
                }else{
                    echo "<span class='error'>Datos incorrectos.</span>";
                }
            }
            ?>
        </p>
        <p>
            <label for="clave">Contraseña: </label>
            <input type="password" id="clave" name="clave">
            <?php
            if(isset($_POST["btnLogin"]) && $error_clave){
                echo "<span class='error'> Campo Vacío</span>";
            }
            ?>
        </p>
        <p>
            <button type="submit" name="btnLogin">Login</button>
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