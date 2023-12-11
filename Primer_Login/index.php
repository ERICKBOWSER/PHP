<?php
session_name("Primer_Login");
session_start();

require "src/ctes_fun.php";

if(isset($_POST["btnSalir"])){
    session_destroy();
    header("Location: index.php");
    exit();
}



// Lo primero es comprobar si el usuario esta creado

    if(isset($_SESSION["usuario"])){
        // Por aquí estoy logueado

        ?>
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Document</title>
            </head>
            <body>
                
            </body>
            </html>l


        <?php
    }else{
        require "/src/vista_login.php";
    }


    if(isset($_POST["btnLogin"])){
        $errorUsuario = $_POST["usuario"] == "";
        $errorClave = $_POST["clave"] == "";

        $errorForm = $errorClave || $errorUsuario;

        if(!$errorForm){
            // Continuo el login
            try{
                $conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
                mysqli_set_charset($conexion, "utf-8");
            }catch(Exception $e){
                die(errorPage("Primer Login", "<h1>Primer Login</h1><p>No se ha podido conectarse a la bbdd: " . $e->getMessage() . "</p></body></html>"));
            }

            try{
                $consulta = "SELECT usuario FROM usuarios WHERE usuario='" . $_POST["usuario"] . "' AND clave= '" . md5($_POST["clave"]);
                $resultado = mysqli_query($conexion, $consulta);
            }catch(Exception $e){
                die(errorPage("Primer Login", "<h1>Primer Login</h1><p>No se ha podido realizar la consulta: " . $e->getMessage() . "</p></body></html>"));
            }

            if(mysqli_num_rows($resultado) > 0){
                // El usuario esta registrado en la BBDD
                $_SESSION["usuario"] = $_POST["usuario"];

                header("Location:index.php");
                exit;
                

            }else{
                $errorForm = true;
            }

            mysqli_free_result($resultado);
            mysqli_close($conexion);
        }
    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Primer login</title>
    <style> 
        .error{color:red}
    </style>
</head>
<body>
    <h1>Primer login</h1>
    <form action="index.php" method="post">
        <p>
            <label for="usuario">Usuario: </label>
            <input type="text" name="usuario" id="usuario" value="<?php if(isset($_POST["usuario"])) echo $_POST["usuario"];?>"/>

            <?php
                if(isset($_POST["btnLogin"]) && $errorUsuario){
                    if($_POST["usuario"] == ""){
                        echo "<span class='error'>Campo vacío</span>";
                    }else{
                        echo "<span class='error'>Usuario / Contraseña no registrado</span>";
                    }
                }
            ?>
        </p>

        <p>
            <label for="clave">Contraseña: </label>
            <input type="password" name="clave" id="clave"/>

            <?php

            ?>
        </p>
        <p>
            <button type="submit" name="btnLogin">login</button>
        </p>
        
    </form>
</body>
</html>