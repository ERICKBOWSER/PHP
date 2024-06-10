<?php
$respuesta=consumir_servicios_REST(DIR_SERV."/notasAlumno/".$datos_usuario_log["cod_usu"],"GET",$datos_env);
$json=json_decode($respuesta,true);
if(!$json)
{
    session_destroy();
    die(error_page("Examen4 DWESE Curso 23-24","<h1>Notas de los alumnos</h1><p>Sin respuesta oportuna de la API</p>"));  
}

if(isset($json["error"]))
{
    session_destroy();
    consumir_servicios_REST(DIR_SERV."/salir","POST",$datos_env);
    die(error_page("Examen4 DWESE Curso 23-24","<h1>Notas de los alumnos</h1><p>".$json["error"]."</p>"));
}

if(isset($json["no_auth"]))
{
    session_unset();
    $_SESSION["seguridad"]="Usted ha dejado de tener acceso a la API. Por favor vuelva a loguearse.";
    header("Location:index.php");
    exit();
}



?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examen4 DWESE Curso 23-24</title>
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
        Bienvenido <strong><?php echo $datos_usuario_log["usuario"];?></strong> - 
        <form class="en_linea" action="index.php" method="post">
            <button class="enlace" name="btnSalir" type="submit">Salir</button>
        </form>
    </div>
   
    <?php
    echo "<h2>Notas del Alumno ".$datos_usuario_log["nombre"]."</h2>";
    echo "<table>";
    echo "<tr><th>Asignatura</th><th>Nota</th></tr>";
    foreach($json["notas"] as $tupla)
    {
        echo "<tr>";
        echo "<td>".$tupla["denominacion"]."</td>";
        echo "<td>".$tupla["nota"]."</td>";
        echo "</tr>";
    }
    echo "</table>";
    ?>
</body>
</html>