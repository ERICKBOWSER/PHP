<?php

define("SERVIDOR_BD","localhost");
define("USUARIO_BD","jose");
define("CLAVE_BD","josefa");
define("NOMBRE_BD","bd_videoclub");

function error_page($title,$body)
{
    $page='<!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>'.$title.'</title>
    </head>
    <body>'.$body.'</body>
    </html>';
    return $page;
}

function repetido($conexion,$tabla,$columna,$valor,$columna_clave=null,$valor_clave=null)
{
    try
    {
        if(isset($columna_clave))
            $consulta="select * from ".$tabla." where ".$columna."='".$valor."' AND ".$columna_clave."<>'".$valor_clave."'";
        else
            $consulta="select * from ".$tabla." where ".$columna."='".$valor."'";

        $resultado=mysqli_query($conexion, $consulta);
        $respuesta=mysqli_num_rows($resultado)>0;
        mysqli_free_result($resultado);
    }
    catch(Exception $e)
    {
        $respuesta=$e->getMessage();
    }
    return $respuesta;
}

function tiene_extension($nombre)
{
    return explode(".",$nombre);
}

?>