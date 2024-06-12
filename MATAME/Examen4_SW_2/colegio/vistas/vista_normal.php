
<?php
$url=DIR_SERV."/notasAlumno/".$datos_usuario_log["cod_usu"];
$respuesta = consumir_servicios_REST($url, "GET", $datos_env);
$json=json_decode($respuesta, true);

if(!$json){
    session_destroy();
    die(error_page("Notas de alumnos", "<h1>Notas de los alumnos</h1><p>Error al consumir el servicio: ".$url."</p>"));
}

if(isset($json["error"])){
    session_destroy();
    die(error_page("Notas de alumnos", "<h1>Notas de los alumnos</h1><p>".$json["error"]."</p>"));
}

if(isset($json["no_auth"])){
    session_unset();
    $_SESSION["seguridad"]="Usted ya no se encuentra logueado desde vista_normal";
    consumir_servicios_REST(DIR_SERV."/salir", "POST", $datos_env);
    header("Location:index.php");
    exit;
}

$obtenerNotas=$json["notas"];



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
    <p>
        <div>
            Bienvenido <strong><?php echo $datos_usuario_log["usuario"];?></strong>-
            <form action="index.php" method="post" class="en_linea">
                <button class="enlace" type="submit" name="btnSalir" id="btnSalir">Salir</button>
            </form>
        </div>
    </p>
    <h2>Notas del alumno <?php echo $datos_usuario_log["nombre"];?></h2>

    <table>
        <tr>
            <th>Asignatura</th>
            <th>Nota</th>
        </tr>
        <?php
        foreach ($obtenerNotas as $tupla) {
            echo "<tr>";
            echo "<td>".$tupla["denominacion"]."</td>";
            echo "<td>".$tupla["nota"]."</td>";
            echo "</tr>";
        }
        ?>

    </table>
</body>
</html>




