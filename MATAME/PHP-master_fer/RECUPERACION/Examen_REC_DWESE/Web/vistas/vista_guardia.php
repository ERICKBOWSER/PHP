<?php
if (isset($_POST["btnDetalle"])) {

    $url = DIR_SERV . "/usuario/" . $_POST["btnDetalle"];
    $respuesta = consumir_servicios_REST($url, "GET", $datos);
    $obj2 = json_decode($respuesta);

    if (!$obj2) {
        session_destroy();
        die(error_page("Error", "<p>Obj no creado<p>"));
    }

    if (isset($obj2->error)) {
        session_destroy();
        consumir_servicios_REST(DIR_SERV . "/salir", "POST", $datos);
        die(error_page("Error", "<p>Error en la API<p>"));
    }
    if (isset($obj2->no_auth)) {
        session_unset();
        $_SESSION["seguridad"] = "Se ha quedado sin tiempo en la API";
        consumir_servicios_REST(DIR_SERV . "/salir", "POST", $datos);
        header("Location:index.php");
        exit;
    }
}


function llamadaApiUsuarios($hora)
{
    $datos["api_session"] = $_SESSION["api_session"];
    $url = DIR_SERV . "/usuariosGuardia/" . date("w") . "/" . $hora;
    $respuesta = consumir_servicios_REST($url, "GET", $datos);
    $obj = json_decode($respuesta);

    if (!$obj) {
        session_destroy();
        die(error_page("Error", "<p>Obj no creado<p>"));
    }

    if (isset($obj->error)) {
        session_destroy();
        consumir_servicios_REST(DIR_SERV . "/salir", "POST", $datos);
        die(error_page("Error", "<p>Error en la API<p>"));
    }

    if (isset($obj->no_auth)) {
        session_unset();
        $_SESSION["seguridad"] = "Se ha quedado sin tiempo en la API";
        consumir_servicios_REST(DIR_SERV . "/salir", "POST", $datos);
        header("Location:index.php");
        exit;
    }

    return $obj;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de guardias</title>
    <style>
        .enlace {
            background: none;
            border: none;
            color: blue;
            text-decoration: underline;
            cursor: pointer;
        }

        .enLinea {
            display: inline;
        }

        table {
            margin: 0 auto;
        }

        th {
            background-color: lightgrey;
        }

        table,
        th,
        td,
        tr {
            border: 1px solid black;
            border-collapse: collapse;
        }
    </style>
</head>

<body>
    <h1>Gestión de Guardias</h1>
    <div>
        Bienvenido <?php echo $datos_usu_log->usuario ?> -
        <form class="enLinea" action="index.php" method="post">
            <button class="enlace" name="btnSalir">Salir</button>
        </form>
    </div>

    <?php

    $dias[1] = "Lunes";
    $dias[2] = "Martes";
    $dias[3] = "Miercoles";
    $dias[4] = "Jueves";
    $dias[5] = "Viernes";

    echo "<h2>Hoy es " . $dias[date("w")] . "</h2>";

    $horas[1] = "8:15 – 9:15";
    $horas[2] = "9:15 –10:15";
    $horas[3] = "10:15 –11:15";
    $horas[4] = "11:15 –11:45";  // recreo no se muestra
    $horas[5] = "11:45 –12:45";
    $horas[6] = "12:45 –13:45";
    $horas[7] = "13:45 –14:45";

    echo "<table>";

    echo "<tr><th>Hora</th><th>Profesor de Guardia</th>";
    if (isset($_POST["btnDetalle"])) {
        echo "<th>Información del Profesor con Id:" . $_POST["btnDetalle"] . "</th></tr>";
    } else {
        echo "<th>Información del Profesor con Id:</th></tr>";
    }

    for ($hora = 1; $hora <= 7; $hora++) {
        if ($hora != 4) {
            echo "<tr>";
            echo "<td>" . $horas[$hora] . "</td>";
            // funcion para coger los usuarios de x hora ( lo sigue haciendo mal )
            $obj = llamadaApiUsuarios($hora);

            echo "<td>";
            echo "<ol>";
            foreach ($obj->usuarios as $tupla) {
                echo "<form action='index.php' method='post'>";
                echo "<li><button class='enlace' name='btnDetalle' value='" . $tupla->id_usuario . "'>" . $tupla->nombre . "</button></li>";
                echo "</form>";
            }
            echo "</ol>";
            echo "</td>";

            if (isset($_POST["btnDetalle"])) {
                if ($hora == 1) {
                    echo "<td>";
                    echo "<p><strong>Nombre:</strong>" . $obj2->usuario->nombre . "</p>";
                    echo "<p><strong>Usuario:</strong>" . $obj2->usuario->usuario . "</p>";
                    echo "<p><strong>Contraseña:</strong></p>";
                    if (isset($obj2->usuario->email)) {
                        echo "<p><strong>Email:</strong>" . $obj2->usuario->email . "</p>";
                    } else {
                        echo "<p><strong>Email:</strong> Email no disponible</p>";
                    }
                    echo "</td>";
                }
            }
            echo "</tr>";
        }
    }
    echo "</table>";
    ?>
</body>

</html>