<?php
if(isset($_POST["btnEntrar"])){

    // PRIMERO COMPROBAMOS QUE LOS DATOS ENVIADOS NO TENGAN FALLOS
    $error_usuario=$_POST["usuario"]=="";
    $error_clave=$_POST["clave"]=="";
    $error_form=$error_usuario || $error_clave;

    if(!$error_form){
        $datos["usuario"]=$_POST["usuario"];
        $datos["clave"]=$_POST["clave"];


        $url=DIR_SERV."/login";
        $respuesta=consumir_servicios_REST($url, "POST", $datos);
        $json=json_decode($respuesta, true);
        if(!$json){
            session_destroy();
            die(error_page("Libreria", "<h1>Libreria</h1><p>Error al consumir el servicio. ".$url."</p>"));
        }

        if(isset($json["error"])){
            session_destroy();
            die(error_page("Libreria", "<h1>Libreria</h1><p>".$json["error"]."</p>"));
        }

        if(isset($json["usuario"])){
            $_SESSION["usuario"]=$json["usuario"]["lector"];
            $_SESSION["clave"]=$json["usuario"]["clave"];
            $_SESSION["ult_accion"]=time();
            $_SESSION["api_session"]=$json["api_session"];

            if($json["usuario"]["tipo"] == "normal"){
                header("Location:index.php");
            }else{
                header("Location:admin/gest_libros.php");
            }
            exit;
        }else{
            $error_usuario=true;
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
</head>
<body>
    <div>
        <h1>Libreria</h1>
        <form action="index.php" method="post">
            <p>
                <label for="usuario">Usuario: </label>
                <input type="text" name="usuario" id="usuario" value="<?php if(isset($_POST["usuario"])) echo $_POST["usuario"];?>">
                <?php
                if(isset($_POST["btnEntrar"]) && $error_usuario){
                    if($_POST["usuario"]==""){
                        echo "<span class='error'>Campo vacío</span>";
                    }else{
                        echo "<span class='error'>Datos incorrectos</span>";
                    }
                }
                ?>
            </p>
            <p>
                <label for="clave">Clave: </label>
                <input type="password" name="clave" id="clave">
                <?php
                if(isset($_POST["btnEntrar"]) && $error_clave){
                    if($_POST["clave"] == ""){
                        echo "<span class='error'>Campo vacío</span>";
                    }
                }
                ?>
            </p>
            <button type="submit" name="btnEntrar" id="btnEntrar">Entrar</button>
        </form>
    </div>    
    <?php
    if(isset($_SESSION["seguridad"])){
        echo "<p class='mensaje'>".$_SESSION["seguridad"]."</p>";
        session_destroy();
    }
    ?>
</body>
</html>



