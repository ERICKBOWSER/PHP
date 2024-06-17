<?php
$url=DIR_SERV."/horarioProfesor/".$_SESSION["id_usuario"];
$respuesta=consumir_servicios_REST($url, "GET", $datos_env);
$json=json_decode($respuesta, true);
if(!$json){
    session_destroy();
    die(error_page("Examen final", "<h1>Examen final PHP</h1><p>Error consumiendo los servicios desde vista_normal: ".$url."</p>"));
}

if(isset($json["error"])){
    session_destroy();
    consumir_servicios_REST(DIR_SERV."/salir", "POST", $datos_env);
    die(error_page("Examen final", "<h1>Examen final PHP</h1><p>".$json["error"]."</p>"));
}

if(isset($json["no_auth"])){
    session_unset();
    $_SESSION["seguridad"]="Usted ya no se encuentra logueado desde seguridad";
    header("Location:index.php");
    exit;
}

$horarioProfesor=$json["horarioProfesor"]; // horario: dia, hora, grupo, aula

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .en_linea{display:inline}
        .enlace{border:none;background:none;color:blue;text-decoration:underline;cursor:pointer}
        .mensaje{font-size:1.25em;color:blue}
        table,th, td{border:1px solid black;}
        table{border-collapse:collapse;text-align:center}
        th{background-color:#CCC}
        .horas{background-color:#CCC}
    </style>
</head>
<body>
    <h1>Examen Final PHP</h1>
    <div>
        Bienvenido <strong><?php echo $datos_usuario_log["usuario"];?></strong>
        <form action="index.php" method="post">
            <button type="submit" class="enlace" name="btnSalir">Salir</submit>
        </form>
    </div>
    <h2>Su horario</h2>
    <h3>Horario del Profesor: <?php echo $datos_usuario_log["nombre"];?></h3>

    <?php
    $dias[]="Lunes";
    $dias[]="Martes";
    $dias[]="Miércoles";
    $dias[]="Jueves";
    $dias[]="Viernes";

    $horas[1]="8:15-9:15";
    $horas[2]="9:15-10:15";
    $horas[3]="10:15-11:15";
    $horas[4]="11:15-11:45";
    $horas[5]="11:45-12:45";
    $horas[6]="12:45-13:45";
    $horas[7]="13:45-14:45";

    echo "<table>";
    echo "<tr>
        <th></th>
        <th>Lunes</th>
        <th>Martes</th>
        <th>Miércoles</th>
        <th>Jueves</th>
        <th>Viernes</th>
        </tr>";

    // MOSTRAMOS LA TABLA
    for($hora=1; $hora<=7; $hora++){
        
        // Creamos nueva fila
        echo "<tr>";
            // CADA VEZ QUE EMPIECE UNA NUEVA FILA PRIMERO COLOCAMOS LAS HORAS
            echo "<td class='horas' >" . $horas[$hora] . "</td>";

            // SI LA HORA ES 4 ES QUE ESTAMOS EN RECREO POR LO QUE CREAMOS UN COLSPAN PARA QUE LAS COLUMNAS NO SE RELLENEN
            if($hora==4){
                echo "<td colspan='5'>RECREO</td>";
            }else{
                
                for($dia=1; $dia<=5; $dia++){
                    // POR CADA DÍA CREAMOS UNA COLUMNA
                    echo "<td>";

                    // CREAMOS UN BUCLE SEGÚN EL LARGO DEL ARRAY DEL horarioProfesor
                    for($i=0; $i < count($horarioProfesor); $i++){
                        // RECORREMOS EL ARRAY Y COMPROBAMOS SI EL DIA ES IGUAL QUE EL DÍA QUE ESTAMOS RECORRIENDO, 
                        // Y LO MISMO CON LAS HORAS, SI SON IGUALES LO IMPRIMIMOS EN LA MISMA COLUMNA
                        if($horarioProfesor[$i]["dia"]== $dia && $horarioProfesor[$i]["hora"]==$hora){
                            // MOSTRAMOS EL GRUPO Y EL AULA
                            echo "".$horarioProfesor[$i]["grupos"]."<br/>";
                            echo "(".$horarioProfesor[$i]["aulas"].")<br/>";
                        }
                    }
                    echo "</td>";
                }
            }
        echo "</tr>";
    }
    echo "</table>";   

    ?>
</body>
</html>


