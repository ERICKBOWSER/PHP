<?php

$url=DIR_SERV . "/obtenerHorario" . $datos_usuario_log->id_usuario;
$respuesta=consumir_servicios_REST($url, "GET", $datos);
$obj2 = json_decode($respuesta);

if(!$obj2){
    session_destroy();
    die(error_page("Examen3", "<h1>Examen3</h1><p>Error consumiendo el servicio en NORMAL: " . $url . "</p>"));
}
if(isset($obj2->error)){
    session_destroy();
    die(error_page("Examen3", "<h1>Examen3</h1><p>Examen3 error</p>" . $obj2->error . "</p>"));
}

if(isset($obj2->no_auth)){
    session_unset();
    $_SESSION["seguridad"] = "El tiempo de sesión de la API ha caducado";
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam 3 clase</title>
    <style>
        .enlinea{display:inline}
        .enlace{border:none;background:none;text-decoration:underline;color:blue;cursor:pointer}
        .centro{text-align:center}
        .tabla_hor{width:80%;margin:0 auto; border-collapse:collapse; text-align:center;  }
        .tabla_hor, .tabla_hor th, .tabla_hor td{border:1px solid black}
        .tabla_hor th{background-color:#CCC}
    </style>
</head>
<body>
    <h1>Exam 3 clase</h1>
    <div>Bienvenido<strong><?php echo $datos_usuario_log->usuario;?></strong> -
    <!-- HACE FALTA EL FORM PARA ENVIAR LOS DATOS-->
        <form class='enlinea' action='index.php' method='post'>
            <button class='enlace' type='submit' name='btnSalir'>Salir</button>
        </form>
    </div>
    
<?php
    foreach($obj2->horario as $tupla){

        if(isset($horario[$tupla->dia][$tupla->hora])){
            $horario[$tupla->dia][$tupla->hora] .= "/" . $tupla->nombre;
        }else{
            $horario[$tupla->dia][$tupla->hora] = $tupla->nombre;
        }
    }

    $dias[]= "";
    $dias[]= "Lunes";
    $dias[]= "Martes";
    $dias[]= "Miércoles";
    $dias[]= "Jueves";
    $dias[]= "Viernes";
    $horas[1] = "8:15 - 9:15";
    $horas[] = "9:15 - 10:15";
    $horas[] = "10:15 - 11:15";
    $horas[] = "11:45 - 12:45";
    $horas[] = "12:45 - 13:45";
    $horas[] = "13:45 - 14:45";

    echo "<h3 class='centro'>Horario del Profesor: " . $datos_usuario_log->nombre . "</h3>";
    echo "<table class='tabla-hor'>";
    echo "<tr>";
    for($i=0; $i<=5;$i++){
        echo "<th>" . $dias[$i]. "</th>";
    }
    echo "</tr>";

    for($hora=1; $hora<=7; $hora++){
        echo "<tr>";
        echo "<th>" . $horas[$hora] . "</th>";
        if($hora == 4){
            echo "<td colspan='5'>RECREO</td>";
        }else{
            for($dia=1; $dia<=5;$dia++){
                if(isset($horario[$dia][$hora])){
                    echo "<td>" . $horario[$dia][$hora] . "</td>";
                }else{
                    echo "<td></td>";
                }
            }
        }
    }
    echo "</table>";  
?>
</body>
</html>

