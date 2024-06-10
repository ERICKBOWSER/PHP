<?php
define("DIR_SERV", "http://localhost/PHP/MATAME/Pract3_SW/servicios_rest");

define("MINUTOS", 55);

define("FOTO_DEFECTO", "no_imagen.jpg");

define("RECAPTCHA_V3_SECRET_KEY", '6LeclMUpAAAAAEWK6dHXL83DFHFaxFWE9f0LiRV2');
function consumir_servicios_REST($url,$metodo,$datos=null)
{
    $llamada=curl_init();
    curl_setopt($llamada,CURLOPT_URL,$url);
    curl_setopt($llamada,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($llamada,CURLOPT_CUSTOMREQUEST,$metodo);
    if(isset($datos))
        curl_setopt($llamada,CURLOPT_POSTFIELDS,http_build_query($datos));
    $respuesta=curl_exec($llamada);
    curl_close($llamada);
    return $respuesta;
}

function error_page($title, $body){
    return '<!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>'.$title.'</title
    </head>
    <body>'.$body.'</body>
    </html>';
}

function LetraNIF($dni){
    return substr("TRWAGMYFPDXBNJZSQVHLCKEO", $dni % 23, 1);
}

function dni_bien_escrito($texto){
    $dni=strtoupper($TEXTO);
    return strlen($dni)==9 && is_numeric(substr($dni, 0, 8)) && substr($dni,-1)>="A" && substr($dni, -1)<="Z";
}

function dni_valido($dni){
    return LetraNIF(substr($dni, 0, 8))==strtoupper(substr($dni, -1));
}

?>

