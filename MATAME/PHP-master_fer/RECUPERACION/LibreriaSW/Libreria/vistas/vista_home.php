<?php
if (isset($_POST["btnEntrar"])) {

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
            die(error_page("Práctica Rec 3B", "<h1>Práctica Rec 3</h1><p>Sin respuesta oportuna de la API</p>"));
        }
        if (isset($json["error_bd"])) {
            session_destroy();
            die(error_page("Práctica Rec 3B", "<h1>Práctica Rec 3</h1><p>" . $json["error_bd"] . "</p>"));
        }


        if (isset($json["usuario"])) {

            $_SESSION["usuario"] = $json["usuario"]["lector"];
            $_SESSION["clave"] = $json["usuario"]["clave"];
            $_SESSION["ultm_accion"] = time();
            $_SESSION["api_key"] = $json["api_key"];

            if ($json["usuario"]["tipo"] == "normal")
                header("Location:index.php");

            else
                header("Location:admin/gest_libros.php");

            exit();
        } else
            $error_usuario = true;
    }
}


$respuesta = consumir_servicios_REST(DIR_SERV . "/obtener_libros_home", "GET");
$json = json_decode($respuesta, true);

if (!$json) {
    session_destroy();
    die(error_page("Práctica Rec 3B", "<h1>Práctica Rec 3B</h1><p>Sin respuesta oportuna de la API</p>"));
}

if (isset($json["error_bd"])) {

    session_destroy();
    die(error_page("Práctica Rec 3B", "<h1>Práctica Rec 3B</h1><p>" . $json["error_bd"] . "</p>"));
}



?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Librería</title>
    <style>
        .error {
            color: red
        }

        .en_linea {
            display: inline
        }

        .enlace {
            border: none;
            background: none;
            color: blue;
            text-decoration: underline;
            cursor: pointer
        }

        table {
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid black
        }

        th {
            background-color: #CCC
        }

        .reducida {
            height: 100px
        }

        .img_editar {
            width: 30%
        }

        .centrar {
            width: 80%;
            margin: 0 auto;
        }

        .mensaje {
            font-size: 1.25rem;
            color: blue
        }

        #t_editar,
        #t_editar td {
            border: none
        }

        .centrado {
            text-align: center;
        }

        .d_flex {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.5em
        }

        .contenedor {
            display: flex;
            flex-wrap: wrap;
        }

        .list_libros {
            border: 1px solid black;
            margin: 0.5rem;
            flex: 0 25%;
        }
    </style>
</head>

<body>
    <h1>Librería</h1>
    <form action="index.php" method="post">
        <p>
            <label for="usuario">Usuario: </label>
            <input type="text" name="usuario" id="usuario" value="<?php if (isset($_POST["usuario"])) echo $_POST["usuario"]; ?>">
            <?php
            if (isset($_POST["btnEntrar"]) && $error_usuario) {
                if ($_POST["usuario"] == "")
                    echo "<span class='error'> Campo vacío</span>";
                else
                    echo "<span class='error'> Usuario y/o Contraseña no válidos</span>";
            }

            ?>
        </p>
        <p>
            <label for="clave">Contraseña: </label>
            <input type="password" name="clave" id="clave">
            <?php
            if (isset($_POST["btnEntrar"]) && $error_clave)
                echo "<span class='error'> Campo vacío</span>";
            ?>
        </p>
        <p>
            <button type="submit" name="btnEntrar">Entrar</button>

        </p>
    </form>

    <?php
    if (isset($_SESSION["seguridad"])) {
        echo "<p class='mensaje'>" . $_SESSION["seguridad"] . "</p>";
        session_destroy();
    }

    ?>
    <h1>Listado de los Libros</h1>

    <?php

    echo "<div class='contenedor'>";
    foreach ($json["libros"] as $tupla) {
        echo "<div class='list_libros'>";
        echo "<img class='reducida' src='images/" . $tupla['portada'] . "' alt='Foto' title='Foto'></br>";
        echo "<p>" . $tupla['titulo'] . " -- " . $tupla['precio'] . "</p>";
        echo "</div>";
    }

    echo "</div>";

    ?>
</body>

</html>