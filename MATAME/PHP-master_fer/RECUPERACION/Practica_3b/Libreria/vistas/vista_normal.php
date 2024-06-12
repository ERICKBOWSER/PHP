<?php

/*****consulta para mostra la tabla******/

$respuesta = consumir_servicios_REST(DIR_SERV . "/obtener_libros_home", "GET");
$json = json_decode($respuesta, true);
if (!$json) {
    session_destroy();
    die(error_page("Práctica Rec 3B", "<h1>Práctica Rec 3</h1><p>Sin respuesta oportuna de la API</p>"));
}

if (isset($json["error_bd"])) {

    session_destroy();
    consumir_servicios_REST(DIR_SERV . "/salir", "POST", $datos_env);
    die(error_page("Práctica Rec 3B", "<h1>Práctica Rec 3</h1><p>" . $json["error_bd"] . "</p>"));
}


$libros = $json["libros"];


?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Práctica Rec 3B</title>
    <style>
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

        .mensaje {
            font-size: 1.25em;
            color: blue
        }

        .reducida {
            height: 100px
        }

        .img_editar {
            width: 30%
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
    <h1>Práctica Rec 3B</h1>
    <div>
        Bienvenido <strong><?php echo $datos_usuario_log["lector"]; ?></strong> -
        <form class="en_linea" action="index.php" method="post">
            <button class="enlace" name="btnSalir" type="submit">Salir</button>
        </form>
    </div>
    <h1>Listado de los Libros</h1>

    <?php
    echo "<div class='contenedor'>";
    foreach ($libros as $tupla) {
        echo "<div class='list_libros'>";
        echo "<img class='reducida' src='images/" . $tupla["portada"] . "' alt='Foto' title='Foto'></br>";
        echo "<p>" . $tupla["titulo"] . " -- " . $tupla["precio"] . "</p>";
        echo "</div>";
    }
    echo "</div>";
    if (isset($_SESSION["seguridad"])) {
        echo "<p class='mensaje'>" . $_SESSION["seguridad"] . "</p>";
        session_destroy();
    }

    ?>


</body>

</html>