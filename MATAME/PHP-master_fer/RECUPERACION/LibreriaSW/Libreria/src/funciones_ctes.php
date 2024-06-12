<?php

define("SERVIDOR_BD", "localhost");
define("USUARIO_BD", "jose");
define("CLAVE_BD", "josefa");
define("NOMBRE_BD", "bd_libreria_exam");
define("MINUTOS", 5);
define("FOTO_DEFECTO", "no_imagen.jpg");
define("DIR_SERV", "http://localhost/ProyectosCurso_22_23/RECUPERACION/LibreriaSW/servicios_rest");

function consumir_servicios_REST($url, $metodo, $datos = null)
{
    $llamada = curl_init();
    curl_setopt($llamada, CURLOPT_URL, $url);
    curl_setopt($llamada, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($llamada, CURLOPT_CUSTOMREQUEST, $metodo);
    if (isset($datos))
        curl_setopt($llamada, CURLOPT_POSTFIELDS, http_build_query($datos));
    $respuesta = curl_exec($llamada);
    curl_close($llamada);
    return $respuesta;
}


function error_page($title, $body)
{
    return '<!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>' . $title . '</title>
    </head>
    <body>' . $body . '</body>
    </html>';
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

function repetido_editando($conexion, $tabla, $columna, $valor, $columna_clave, $valor_clave)
{
    try {

        $consulta = "SELECT " . $columna . " from " . $tabla . " where " . $columna . "=? AND " . $columna_clave . "<>?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$valor, $valor_clave]);
        $respuesta = $sentencia->rowCount() > 0;
    } catch (PDOException $e) {

        $respuesta = "Imposible realizar la consulta. Error:" . $e->getMessage();
    }

    $sentencia = null;
    return $respuesta;
}
