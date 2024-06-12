<?php
if(isset($_POST["btnVerNotas"])){
    $respuesta=consumir_servicios_REST(DIR_SERV."/notasAlumno/".$_POST["alumno"], "GET", $datos_env);
    $json=json_decode($respuesta, true);
    if(!$json){
        session_destroy();
        die(error_page("Examen4", "<h1>Notas de los alumnos</h1><p>Sin respuesta oportuna de la API</p>"));
    }

    if(isset($json["error"])){
        session_destroy();
        consumir_servicios_REST(DIR_SERV."/salir", "POST", $datos_env);
        die(error_page("Examen4", "<h1>Notas de los alumnos</h1><p>".$json["error"]."</p>"));
    }

    if(isset($json["no_auth"])){
        session_unset();
        $_SESSION["seguridad"]="Usted ha dejado de tener acceso a la API.";
        header("Location:index.php");
        exit();
    }
    $notasAlumno=$json["notasAlumno"];

}


$respuesta=consumir_servicios_REST(DIR_SERV."/alumnos", "GET", $datos_env);
$json=json_decode($respuesta, true);
if(!$json){
    session_destroy();
    die(error_page("Examen4", "<h1>Notas de los alumnos</h1><p>Sin respuesta oportuna de la API</p>"));
}

if(isset($json["error"])){
    session_destroy();
    consumir_servicios_REST(DIR_SERV."/salir", "POST", $datos_env);
    die(error_page("Examen4", "<h1>Notas de los alumnos</h1><p>".$json["error"]."</p>"));
}

if(isset($json["no_auth"])){
    session_unset();
    $_SESSION["seguridad"]="Usted ha dejado de tener acceso a la API.";
    header("Location:index.php");
    exit();
}

$alumnos =$json["alumnos"]


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
    </style>
</head>
<body>
    <h1>Notas de los alumnos</h1>
    <div>
        Bienvenido <strong><?php echo $datos_usuario_log["usuario"];?></strong>-
        <form class="en_linea" action="index.php" method="post">
            <button class="enlace" name="btnSalir" type="submit">Salir</button>
        </form>
    </div>
    <form action="index.php" method="post">
        <select name="alumno" id="alumno">
            <?php
            foreach ($alumnos as $tupla) {
                if(isset($_POST["alumno"]) && $_POST["alumno"]==$tupla["cod_usu"]){
                    echo "<option selected value='".$tupla["cod_usu"]."'>".$tupla["nombre"]."</option>";
                    $nombre_alumno=$tupla["nombre"];
                }else{
                    echo "<option value='".$tupla["cod_usu"]."'>".$tupla["nombre"]."</option>";
                }
                
            }   
            ?>
        </select>
        <button type="submit" name="btnVerNotas">Ver notas</button>
    </form>

    <?php
    if(isset($_POST["btnVerNotas"])){
        echo "<h2>Notas del alumno ".$nombre_alumno."</h2>";
        echo "<table>";
            echo "<tr>";
                echo "<th>Asignaturas</th><th>Nota</th><th>Acción</th>";
            echo "</tr>";
            foreach ($notasAlumno as $tupla) {
                echo "<tr>";
                echo "<td>".$tupla["denominacion"]."</td>";
                echo "<td>".$tupla["nota"]."</td>";
                echo "</tr>";
            }
        echo "</table>";
    }

?>
</body>
</html>