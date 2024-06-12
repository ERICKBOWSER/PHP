<?php
define("MINUTOS", 5);

define("SERVIDOR_BD", "localhost");
define("USUARIO_BD", "jose");
define("CLAVE_BD", "josefa");
define("NOMBRE_BD", "bd_libreria_exam");


function error_page($title, $body)
{
    $page = '<!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>' . $title . '</title>
    </head>
    <body>' . $body . '</body>
    </html>';
    return $page;
}


function repetido($conexion, $tabla, $columna, $valor)
{
    try {

        $consulta = "SELECT " . $columna . " from " . $tabla . " where " . $columna . "=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$valor]);
        $respuesta = $sentencia->rowCount() > 0;
    } catch (PDOException $e) {

        $respuesta = "Imposible realizar la consulta. Error:" . $e->getMessage();
    }

    $sentencia = null;
    return $respuesta;
}
