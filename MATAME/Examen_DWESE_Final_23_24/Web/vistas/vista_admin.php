<?php
if(isset($_POST["btnQuitar"]))
{
    $id_grupo = $_POST["grupos"];
    $dia = $_POST["dia"];
    $hora = $_POST["hora"];
    $usuario=  $_POST["usuario"];

    $respuesta = consumir_servicios_REST(DIR_SERV . "/borrarProfesor/" . $dia . "/" . $hora . "/" . $id_grupo . "/" . $usuario . "", "DELETE", $datos_env);
    $obj = json_decode($respuesta, true);
    if (!$obj) {
        session_destroy();
        die(error_page("Examen Final PHP", "<h1>Examen Final PHP</h1><p>Error consumiendo el servicio: Horarios Grupos</p>"));
    }

    if (isset($obj["error"])) {
        session_destroy();
        die(error_page("Examen Final PHP", "<h1>Examen Final PHP</h1><p>" . $obj["error"] . "</p>"));
    }
    $_SESSION["mensaje_accion"]=$obj["mensaje"];


}


if (isset($_POST["btnEditar"])) {
    $id_grupo = $_POST["grupos"];
    $dia = $_POST["dia"];
    $hora = $_POST["hora"];

    $respuesta = consumir_servicios_REST(DIR_SERV . "/profesoresOcupados/" . $dia . "/" . $hora . "/" . $id_grupo . "", "GET", $datos_env);
    $obj = json_decode($respuesta, true);
    if (!$obj) {
        session_destroy();
        die(error_page("Examen Final PHP", "<h1>Examen Final PHP</h1><p>Error consumiendo el servicio: Horarios Grupos</p>"));
    }

    if (isset($obj["error"])) {
        session_destroy();
        die(error_page("Examen Final PHP", "<h1>Examen Final PHP</h1><p>" . $obj["error"] . "</p>"));
    }

    $profesores_ocupados = $obj["profesores_Ocupados"];

    $respuesta = consumir_servicios_REST(DIR_SERV . "/profesoresLibres/" . $dia . "/" . $hora . "/" . $id_grupo . "", "GET", $datos_env);
    $obj = json_decode($respuesta, true);
    if (!$obj) {
        session_destroy();
        die(error_page("Examen Final PHP", "<h1>Examen Final PHP</h1><p>Error consumiendo el servicio: Horarios Grupos</p>"));
    }

    if (isset($obj["error"])) {
        session_destroy();
        die(error_page("Examen Final PHP", "<h1>Examen Final PHP</h1><p>" . $obj["error"] . "</p>"));
    }

    $profesores_libres = $obj["profesores_libres"];


}




if (isset($_POST["grupos"])) {
    $id_grupo = $_POST["grupos"];

    $respuesta = consumir_servicios_REST(DIR_SERV . "/horarioGrupo/" . $id_grupo . "", "GET", $datos_env);
    $obj = json_decode($respuesta, true);
    if (!$obj) {
        session_destroy();
        die(error_page("Examen Final PHP", "<h1>Examen Final PHP</h1><p>Error consumiendo el servicio: Horarios Grupos</p>"));
    }

    if (isset($obj["error"])) {
        session_destroy();
        die(error_page("Examen Final PHP", "<h1>Examen Final PHP</h1><p>" . $obj["error"] . "</p>"));
    }

    $horarios_grupo = $obj["horario"];
}




$respuesta = consumir_servicios_REST(DIR_SERV . "/todosGrupos", "GET", $datos_env);
$obj = json_decode($respuesta, true);
if (!$obj) {
    session_destroy();
    die(error_page("Examen Final PHP", "<h1>Examen Final PHP</h1><p>Error consumiendo el servicio: Horarios Profeso </p>"));
}

if (isset($obj["error"])) {
    session_destroy();
    die(error_page("Examen Final PHP", "<h1>Examen Final PHP</h1><p>" . $obj["error"] . "</p>"));
}

$grupos = $obj["grupos"];
//var_dump($grupos);


?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examen Final PHP</title>
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

        table,
        th,
        td {
            border: 1px solid black;
        }

        table {
            border-collapse: collapse;
            text-align: center
        }

        th {
            background-color: #CCC
        }

        .horas {
            background-color: #CCC
        }
    </style>
</head>

<body>
    <h1>Examen Final PHP</h1>
    <div>
        Bienvenido <strong><?php echo $datos_usuario_log["usuario"]; ?></strong> -
        <form class="en_linea" action="index.php" method="post">
            <button class="enlace" name="btnSalir" type="submit">Salir</button>
        </form>
    </div>
    <h2>Horarios Grupo</h2>

    <form action="index.php" method="post">
        <p>
            <?php
            echo "<select name='grupos' id='grupos'>";

            foreach ($grupos as $tupla) {
                echo "<option value='" . $tupla["id_grupo"] . "'>" . $tupla["nombre"] . "</option>";
            }


            echo "</select>";
            echo "<button name='btnVerHorario' value=''>Ver Horario</button>";
            ?>
        </p>

    </form>

    <?php
    if (isset($_POST["btnVerHorario"]) || isset($_POST["btnEditar"])) {

        $dias[1] = "Lunes";
        $dias[2] = "Martes";
        $dias[3] = "Miercoles";
        $dias[4] = "Jueves";
        $dias[5] = "Viernes";

        $horas[1] = "8:15-9:15";
        $horas[2] = "9:15-10:15";
        $horas[3] = "10:15-11:15";
        $horas[4] = "11:15-11:45";
        $horas[5] = "11:45-12:45";
        $horas[6] = "12:45-13:45";
        $horas[7] = "13:45-14:45";

        echo "<table>";
        echo "<tr><th></th><th>Lunes</th><th>Martes</th><th>Miercoles</th><th>Jueves</th><th>Viernes</th></tr>";

        for ($hora = 1; $hora <= 7; $hora++) {

            echo "<tr>";
            echo "<td class='horas'>" . $horas[$hora] . "</td>";
            if ($hora == 4) {
                echo "<td colspan='5'>RECREO</td>";
            } else {

                for ($dia = 1; $dia <= 5; $dia++) {
                    echo "<td>";

                    for ($i = 0; $i < count($horarios_grupo); $i++) {

                        if ($horarios_grupo[$i]["dia"] == $dia && $horarios_grupo[$i]["hora"] == $hora) {
                            echo "" . $horarios_grupo[$i]["usuario"] . "";
                            echo "(" . $horarios_grupo[$i]["aula"] . ")<br/>";
                        }
                    }
                    echo "<form action='index.php' method='post'>";
                    echo "<button class='enlace' type='submit' name='btnEditar'>Editar</button>";
                    echo "<input type='hidden' name='dia' value='" . $dia . "'>";
                    echo "<input type='hidden' name='hora' value='" . $hora . "'>";
                    echo "<input type='hidden' name='grupos' value='" . $_POST["grupos"] . "'>";
                    echo "<input type='hidden' name='btnVerHorarios' value='" . $_POST["grupos"] . "'>";

                    echo "</form>";
                    echo "</td>";
                }
            }

            echo "<tr>";
        }
        echo "<table>";
        if (isset($_POST["btnEditar"])||isset($_POST["btnQuitar"])) {
            echo "<h3>Editando la " . $_POST["hora"] . "º Hora (" . $horas[$_POST["hora"]] . ") del " . $dias[$_POST["dia"]] . "</h3>";

            echo "<table>";
            echo "<tr><th>Profesor(Aula)</th><th>Acción</th></tr>";
            foreach ($profesores_ocupados as $tupla) {
                echo "<tr>";
                echo "<td>" . $tupla["usuario"] . " (" . $tupla["nombre"] . ")</td>";
                echo "<td>";
                echo "<form action='index.php' method='post'>";
                echo "<button class='enlace' type='submit' name='btnQuitar'>Quitar</button>";
                echo "<input type='hidden' name='dia' value='" .$_POST["dia"] . "'>";
                echo "<input type='hidden' name='hora' value='" .$_POST["hora"] . "'>";
                echo "<input type='hidden' name='dia' value='" .$_POST["dia"] . "'>";
                echo "<input type='hidden' name='grupos' value='" . $_POST["grupos"] . "'>";
                echo "<input type='hidden' name='usuario' value='" . $tupla["id_usuario"] . "'>";
                  echo "<input type='hidden' name='btnEditar' value=''>";
                echo "</form>";
                echo "</td>";
                echo "</tr>";
            }
            echo "</table>";

    ?>
            <form action="index.php" method="post">
                <p>
                    <?php
                    echo "<select name='noGrupos' id='noGrupos'>";

                    foreach ($profesores_libres as $tupla) {
                        echo "<option value='" . $tupla["id_usuario"] . "'>" . $tupla["nombre"] . "</option>";
                    }


                    echo "</select>";
                    echo "<button name='btnAgregar' value=''>Añadir</button>";
                    ?>
                </p>

            </form>
    <?php
        }

    }
    if(isset($_SESSION["mensaje_accion"]))
    {
        echo "<p class='mensaje'>".$_SESSION["mensaje_accion"]."</p>";
        unset($_SESSION["mensaje_accion"]);
    }
   
    ?>




</body>

</html>