<?php
if(isset($_POST["btnLogin"])){
    // COMPROBAMOS ERRORES
    $error_usuario=$_POST["usuario"] == "";
    $error_clave=$_POST["clave"] == "";
    $error_form=$error_usuario||$error_clave;

    if(!$error_form){
        $datos["usuario"]=$_POST["usuario"];
        $datos["clave"]=md5($_POST["clave"]);

        $url=DIR_SERV."/login";
        $respuesta=consumir_servicios_REST($url, "POST", $datos);
        $json=json_decode($respuesta, true);

        if(!$json){
            var_dump($json);
            session_destroy();
            die(error_page("Notas alumno", "<h1>Notas de los alumnos</h1><p>Error consumiendo el servicio. Error: ".$url."</p>"));
        }

        if(isset($json["error"])){
            session_destroy();
            die(error_page("Notas alumno","<h1>Notas de los alumnos</h1><p>".$json["error"]."</p>"));
        }

        if(isset($json["no_auth"])){
            session_unset();
            $_SESSION["seguridad"]="Usted ya no se encuentra logueado. Por favor logueese de nuevo desde btnLogin";
            header("Location:index.php");
            exit();            
        }

        if(isset($obj["mensaje"])){
            $error_usuario = true;
        }else{
            $_SESSION["usuario"]=$obj["usuario"]["usuario"];
            $_SESSION["clave"]=$obj["usuario"]["clave"];
            $_SESSION["ult_accion"]=time(); // Tiempo activo el inicio de sesión
            $_SESSION["api_session"]=$obj["api_session"];

            // Dependiendo del tipo de cuenta te envia a una vista u otra
            if($obj["usuario"]["tipo"]=="tutor"){
                header("Location:admin/index.php");
            }else{
                header("Location:index.php");
            }

            exit;

        }


    }
}





?>
<!DOCTYPE html>
<html lang="es">
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
    <p>
    <form action="index.php" method="post">
        <p>
            <label for="usuario">Usuario: </label>
            <input type="text" name="usuario" id="usuario" value="<?php if(isset($_POST["usuario"])) echo $_POST["usuario"];?>">
            <?php
            if(isset($_POST["btnLogin"]) && $error_usuario){
                if($_POST["usuario"]==""){
                    echo "<span class='error'>Campo vacío</span>";
                }else{
                    echo "<span class='error'>Los datos introducidos son incorrectos</span>";
                }
            }
            ?>
        </p>
        <p>
            <label for="clave">Contraseña: </label>
            <input type="password" name="clave" id="clave">
            <?php
            if(isset($_POST["btnLogin"]) && $error_clave){
                    echo "<span class='error'>Campo vacío</span>";
            }
            ?>
        </p>
        <button type="submit" name="btnLogin" id="btnLogin">Login</button>
    </form>        
    <?php
    // IMPRESCINDIBLE TENERLO PARA INFORMAR DE FALLOS
    if(isset($_SESSION["seguridad"])){
        echo "<p class='mensaje'>".$_SESSION["seguridad"]."</p>";
        session_destroy();
    }
    ?>
    </p>    
</body>
</html>


