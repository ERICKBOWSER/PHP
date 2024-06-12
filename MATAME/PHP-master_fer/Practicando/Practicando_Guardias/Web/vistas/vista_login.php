<?php


if (isset("btnEntrar")) {

    $error_usuario = $_POST["usuario"] == "";
    $error_clave = $_POST["clave"] == "";
    $error_form = $error_usuario || $error_clave;

    if (!$error_form) {

        $datos_env["usuario"] = $_POST["usuario"];
        $datos_env["clave"] = md5($_POST["clave"]);
        $respuesta = consumir_servicios_REST(DIR_SERV . "/login", "POST", $datos_env);
        $json = json_decode($respuesta, true);


        if (!$json) {

            session_destroy();
            die(error_page("Examen", "<h1>Examen</h1><p>Error al consumir la api</p>"));
        }



        if (isset($json["error_bd"])) {
            session_destroy();
            consumir_servicios_REST(DIR_SERV . "/salir", "POST", $datos_env);
            die(error_page("Examen", "<h1>Examen</h1><p>" . $json["error_bd"] . "</p>"));
        }



        if (isset($json["usuario"])) {


            $_SESSION["usuario"] = $json["usuario"]["usuario"];
            $_SESSION["clave"] = $json["usuario"]["clave"];
            $_SESSION["api_session"] = $json["api_session"];
            $_SESSION["ultima_accion"] = time();

            header("Location:index.php");
            exit();
        } else {


            $error_usuario = true;
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
    <h1>Login</h1>
    <form action="index.php" method="post">
        <p>
            <label for="usuario">Usuario:</label>
            <input type="text" name="usuario" id="usuario" value="<?php if (isset($_POST["usuario"])) echo $_POST["usuario"] ?>" />
            <?php
            if (isset($_POST["usuario"]) && $error_usuario) {
                if ($_POST["usuario"] == "") {
                    echo "<span class='mensaje'>Campo vacio</span>";
                } else {
                    echo "<span class='mensaje'>Usuario/Clave Incorrecto</span>";
                }
            }
            ?>
        </p>
        <p>
            <label for="clave">Contraseña:</label>
            <input type="password" name="clave" id="clave" />
            <?php
            if (isset($_POST["usuario"]) && $error_clave) {
                echo "<span class='mensaje'>Campo vacio</span>";
            }
            ?>
        </p>
        <p>
            <button type="submit" name="btnEntrar">Entrar</button>
        </p>
    </form>
</body>

</html>