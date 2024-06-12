<?php

if(isset($_POST["btnVerNotas"])){
    $respuesta=consumir_servicios_REST(DIR_SERV."/notasAlumno/".$_POST["alumnos"], "GET", $datos_env);
    $json=json_decode($respuesta, true);
    if(!$json){
        session_destroy();
        die(error_page("Notas alumnos", "<h1>Notas de los alumnos</h1><p>Error al consumir el servicio desde vista_admin: </p>"));
    }
    
    if(isset($json["error"])){
        session_destroy();
        consumir_servicios_REST(DIR_SERV."/salir", "POST", $datos_env);
        die(error_page("Notas alumnos", "<h1>Notas de los alumnos</h1><p>".$json["error"]."</p>"));
    }
    
    if(isset($json["no_auth"])){
        session_unset();
        $_SESSION["seguridad"]="Usted ya no esta logueado. Por favor vuelva a loguearse";
        header("Location:index.php");
        exit();
    }

    $verNotas = $json["verNotas"];
}

if(isset($_POST["btnVer"]))



// ESTE CÓDIGO SE EJECUTA SIEMPRE AL MOSTRAR LA VISTA

$respuesta=consumir_servicios_REST(DIR_SERV."/alumnos", "GET", $datos_env);
$json=json_decode($respuesta,true);
if(!$json){
    session_destroy();
    die(error_page("Notas alumnos", "<h1>Notas de los alumnos</h1><p>Error al consumir el servicio desde vista_admin: </p>"));
}

if(isset($json["error"])){
    session_destroy();
    consumir_servicios_REST(DIR_SERV."/salir", "POST", $datos_env);
    die(error_page("Notas alumnos", "<h1>Notas de los alumnos</h1><p>".$json["error"]."</p>"));
}

if(isset($json["no_auth"])){
    session_unset();
    $_SESSION["seguridad"]="Usted ya no esta logueado. Por favor vuelva a loguearse";
    header("Location:index.php");
    exit();
}

$alumnos=$json["alumnos"];


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
    <p>
        <form action="index.php" method="post">
        <label for="alumnos">Seleccione un Alumno: </label>
        <select id="alumnos" name="alumnos">
            <?php
            foreach ($alumnos as $tupla) {
                if(isset($_POST["alumnos"]) && $_POST["alumnos"]==$tupla["cod_usu"]){
                    echo "<option selected value='".$tupla["cod_usu"]."'>".$tupla["nombre"]."'</option>";
                    $nombreAlumno = $tupla["nombre"];
                }else{
                    echo "<option value='".$tupla["cod_usu"]."'>".$tupla["nombre"]."'</option>";
                }
            }
            ?>
        </select>
        <button type="submit" name="btnVerNotas">Ver notas</button>
        </form>
    </p>
</body>
</html>




