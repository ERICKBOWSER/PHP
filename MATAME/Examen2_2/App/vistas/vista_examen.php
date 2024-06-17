<?php

if(isset($_POST["profesores"])){

    $respuesta=consumir_servicios_REST(DIR_SERV."/obtenerHorario/".$_POST["profesores"], "GET", $datos_env);
    $json=json_decode($respuesta, true);
    if(!$json){
        session_destroy();
        die(error_page("Examen2 PHP con SW","<h1>Examen2 PHP con SW</h1><p>Sin respuesta oportuna de la API desde vista_examen:profesores</p>"));  
    }

    if(isset($json["error"])){
        session_destroy();
        consumir_servicios_REST(DIR_SERV."/salir", "POST", $datos_env);
        die(error_page("Examen2 PHP con SW","<h1>Examen2 PHP con SW</h1><p>".$json["error"]."</p>"));  
    }

    if(isset($json["no_auth"])){
        session_unset();
        $_SESSION["seguridad"]="Usted ha dejado de tener acceso a la API. desde vista_examen:profesores";
        header("Location:index.php");
        exit();
    }
    $obtenerHorario = $json["obtenerHorario"];

    foreach ($obtenerHorario as $tupla) {
        if(isset($horario_profesor[$tupla["dia"]][$tupla["hora"]])){
            $horario_profesor[$tupla["dia"]][$tupla["hora"]] .="/".$tupla["nombre"];
        }else{
            $horario_profesor[$tupla["dia"]][$tupla["hora"]]=$tupla["nombre"];
        }
    }

}


$respuesta=consumir_servicios_REST(DIR_SERV."/obtenerProfesores", "GET", $datos_env);
$json=json_decode($respuesta, true);
if(!$json){
    session_destroy();
    die(error_page("Examen2 PHP con SW","<h1>Examen2 PHP con SW</h1><p>Sin respuesta oportuna de la API</p>"));  
}

if(isset($json["error"])){
    session_destroy();
    consumir_servicios_REST(DIR_SERV."/salir", "POST", $datos_env);
    die(error_page("Examen2 PHP con SW","<h1>Examen2 PHP con SW</h1><p>".$json["error"]."</p>"));  
}

if(isset($json["no_auth"])){
    session_unset();
    $_SESSION["seguridad"]="Usted ha dejado de tener acceso a la API. Por favor vuelva a loguearse";
    header("Location:index.php");
    exit();
}

$profesores=$json["profesores"]; // RECOGEMOS TODOS LOS DATOS DE LA TABLA PROFESORES





?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examen2 PHP con SW</title>
    <style>
        .en_linea{display:inline}
        .enlace{border:none;background:none;color:blue;text-decoration:underline;cursor:pointer}
        .mensaje{font-size:1.25em;color:blue}
        table,th, td{border:1px solid black;}
        table{border-collapse:collapse;text-align:center}
        th{background-color:#CCC}
    </style>
</head>
<body>
    <h1>Examen2 PHP con SW</h1>
    <div>
        Bienvenido <strong><?php echo $datos_usuario_log["usuario"];?></strong> - 
        <form class="en_linea" action="index.php" method="post">
            <button class="enlace" name="btnSalir" type="submit">Salir</button>
        </form>
    </div>
   <h2>Horario de los Profesores</h2>
   <?php
   if(count($profesores)>0){
    ?>
    <form action="index.php" method="post">
        <p>
            <label for="profesores">Horarios del profesor: </label>
            <select name="profesores" id="profesores">
                <?php
                foreach ($profesores as $tupla) {
                    if(isset($_POST["profesores"]) && $_POST["profesores"]==$tupla["id_usuario"]){
                        echo "<option selected value='".$tupla["id_usuario"]."'>".$tupla["nombre"]."</option>";
                        $nombre_profesor=$tupla["nombre"];
                    }else{
                        echo "<option value='".$tupla["id_usuario"]."'>".$tupla["nombre"]."</option>";
                    }
                }
                ?>
            </select>
            <button type="submit" name="btnVerHorario">Ver Horario</button>
        </p>
    </form>
    <?php
   }else{
        echo "<p>No hay profesor del cual ver su horario</p>";
   }

   if(isset($_POST["profesores"])){
    echo "<h3>Horario del profesor: ".$nombre_profesor."</h3>";
    $horas[1]="8:15 - 9:15";
    $horas[2]="9:15 - 10:15";
    $horas[3]="10:15 - 11:15";
    $horas[4]="11:15 - 11:45";
    $horas[5]="11:45 - 12:45";
    $horas[6]="12:45 - 13:45";
    $horas[7]="13:45 - 14:45";
    
    $dias[]="";
    $dias[]="Lunes";
    $dias[]="Martes";
    $dias[]="Miércoles";
    $dias[]="Jueves";
    $dias[]="Viernes";

    // CREAMOS LA TABLA
    echo "<table>";
    echo "<tr>";
    for($i=0; $i < count($dias); $i++){
        echo "<th>".$dias[$i]."</th>";
    }
    echo "<tr>"; // TERMINAMOS LA PRIMERA FILA

    for($hora=1; $hora<=count($horas); $hora++){
        echo "<tr>"; // NUEVA FILA

        // COLOCAMOS EN LA PRIMERA COLUMNA LAS HORAS
        echo "<th>".$horas[$hora]."</th>";
        if($hora==4){
            echo "<td colspan='5'>RECREO</td>";
        }else{
            for($dia=1; $dia<count($dias); $dia++){
                echo "<td>";
                if(isset($horario_profesor[$dia][$hora])){
                    echo $horario_profesor[$dia][$hora];
                }
            }
        }
        echo "</tr>";
    }
    echo "</table>";



    




   }






?>









