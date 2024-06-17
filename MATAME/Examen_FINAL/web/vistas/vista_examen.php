<?php
if(isset($_POST["grupos"])){
    $respuesta=consumir_servicios_REST(DIR_SERV."/horarioGrupo/". $_POST["grupos"], "GET", $datos_env);
    $json=json_decode($respuesta, true);
    if(!$json){
        session_destroy();
        die(error_page("Examen final", "<h1>Examen final</h1><p>Error consumiendo el servicio desde vista_examen:grupos</p>"));
    }
    
    if(isset($json["error"])){
        session_destroy();
        die(error_page("Examen final", "<h1>Examen final</h1><p>".$json["error"]."</p>"));
    }
    
    if(isset($json["no_auth"])){
        session_unset();
        consumir_servicios_REST(DIR_SERV."/salir", "POST", $datos_env);
        $_SESSION["seguridad"]="Usted ya no esta logueado";
        header("Location:index.php");
        exit();
    }
    
    $horarioGrupos=$json["horarioGrupo"];

}


$respuesta=consumir_servicios_REST(DIR_SERV."/grupos", "GET", $datos_env);
$json=json_decode($respuesta, true);
if(!$json){
    session_destroy();
    die(error_page("Examen final", "<h1>Examen final</h1><p>Error consumiendo el servicio desde vista_examen</p>"));
}

if(isset($json["error"])){
    session_destroy();
    die(error_page("Examen final", "<h1>Examen final</h1><p>".$json["error"]."</p>"));
}

if(isset($json["no_auth"])){
    session_unset();
    consumir_servicios_REST(DIR_SERV."/salir", "POST", $datos_env);
    $_SESSION["seguridad"]="Usted ya no esta logueado";
    header("Location:index.php");
    exit();
}

$grupos=$json["grupos"];


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
    <h2>Horario de los Grupos</h2>
    <form action="index.php" method="post">
        <label for="grupos">Elija el grupo: </label>
        <select name="grupos" id="grupos"> 
            <?php
            foreach ($grupos as $tupla) {
                if(isset($_POST["grupos"]) && $_POST["grupos"] == $tupla["id_grupo"]){
                    echo "<option selected value='".$tupla["id_grupo"]."'>".$tupla["nombre"]."</option>";
                }else{
                    echo "<option value='".$tupla["id_grupo"]."'>".$tupla["nombre"]."</option>";
                }   
            }            
            ?>
        </select>
        <button type="submit" name="verHorarioGrupo">Ver horario</button>
    </form>
    <?php
    if(isset($_POST["grupos"])){

        $dias[0]="";
        $dias[1]="Lunes";
        $dias[2]="Martes";
        $dias[3]="Miercoles";
        $dias[4]="Jueves";
        $dias[5]="Viernes";

        $horas[1]="8:15-9:15";
        $horas[2]="9:15-10:15";
        $horas[3]="10:15-11:15";
        $horas[4]="11:15-11:45";
        $horas[5]="11:45_12:45";
        $horas[6]="12:45-13:45";
        $horas[7]="13:45-14:45";

        echo "<table>";
            echo "<tr>";
            for($i=0; $i <=5;$i++){
                echo "<th>". $dias[$i] . "</th>";
            }
            echo "</tr>";

            for($hora=1; $hora <=7; $hora++){
                echo "<tr>";
                echo "<th>". $horas[$hora] . "</th>";
                if($hora==4){
                    echo "<th colspan='5'>RECREO</th>";
                }else{
                    for($dia=1; $dia <= 5; $dia++){
                        echo "<td>";
                            for($i=0; $i < count($horarioGrupos); $i++){
                                if($horarioGrupos[$i]["dia"]== $dia && $horarioGrupos[$i]["hora"]==$hora){
                                    echo "". $horarioGrupos[$i]["usuario"];
                                    echo "(". $horarioGrupos[$i]["aulas"]. ")<br/>";
                                }
                            }
                            echo "<form action='index.php' method='post'>";
                            echo "<input type='hidden' name='dia' value='". $dia . "'/>";
                            echo "<input type='hidden' name='hora' value='". $hora . "'/>";
                            echo "<input type='hidden' name='grupos' value='". $_POST["grupos"]."'/>";
                            echo "<input type='hidden' name='btnVerHorario' value='". $_POST["grupos"] . "'/>";
                            echo "<button class='enlace' type='submit' name='btnEditar'>Editar</button>";
                            echo "</form>";

                        echo "</td>";
                    }
                }
                echo "</tr>";
            }
        
        
        
        echo "</table>";
  
    }
    ?>
</body>
</html>


