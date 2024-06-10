<?php

if(isset($_POST["btnLogin"])){
    $error_usuario = $_POST["usuario"] == "";
    $error_clave = $_POST["clave"] == "";
    $error_form=$error_usuario || $error_clave;

    // Si hay un fallo en el formulario
    if(!$error_form){
        $url=DIR_SERV."/login";
        $datos["usuario"]=$_POST["usuario"];
        $datos["clave"]=md5($_POST["clave"]);
        
        //Usamos el servicio de LOGIN y le pasamos los parametros como la url, el tipo y los datos
        $respuesta=consumir_servicios_REST($url, "POST", $datos);
        $obj=json_decode($respuesta, true);
        // Si no es un objeto
        if(!$obj){
            var_dump($datos);

            session_destroy();
            die(error_page("Examen 4", "<h1>Notas de los alumnos</h1><p>Error consumiendo el servicio LOGIN desde vista_home: ".$url."</p>"));

        }

        // comprobamos si el objeto tiene el parámetro error
        if(isset($obj["error"])){
            session_destroy();
            die(error_page("Examen 4", "<h1>Error al obtener el objeto desde vista_home: ".$bj->error."</p>"));
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
<html lang="es<">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examen 4 SW  </title>
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
            <label for="usuario">Usuario:</label>
            <input type="text" id="usuario" name="usuario" value="<?php if(isset($_POST["usuario"])) echo $_POST["usuario"];?>">
            <?php
                if(isset($_POST["btnLogin"]) && $error_usuario){
                    // Error si esta vacio
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
            echo "<p class='mensaje'>".$_SESSION["seguridad"]."</p>";
            session_destroy();
        }
    
    ?>
</body>
</html>











