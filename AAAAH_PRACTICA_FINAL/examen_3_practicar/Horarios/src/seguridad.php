<?php

// COMPROBAMOS SI SIGUE LOGUEADO
$url = DIR_SERV . "/logueado";
$datos["api_session"] = $_SESSION["api_session"];
$respuesta = consumir_servicios_REST($url, "GET", $datos);
$obj = json_decode(($respuesta));

if(!$obj){
    session_destroy();
    die(error_page("Examen 2", "<h1>Examen 2</h1><p>Error consumiendo el servicio: " . $url . "</p>"));
}

if(isset($obj->error)){
    session_destroy();
    die(error_page("Examen 2", "<h1>Examen 2</h1><p>Examen2</p>" . $obj->error . "</p>"));
}

// EL TIEMPO DE SESIÓN HA TERMINADO, OBLIGAMOS A QUE SE LOGUEE
if(isset($obj->no_auth)){
    session_unset();
    $_SESSION["seguridad"] = "El timepo de sesión de la api ha caducado";
    header("Location: " . $salto);
    exit;
}

// ESTOY BANEADO
if(isset($obj->mensaje)){
    session_unset();
    $_SESSION["seguridad"] = "Usted ya no se encuentra registrado en la BD";
    header("Location: " . $salto);
    exit;
}

$datos_usuario_log = $obj -> usuario; // SI HA LLEGADO HASTA AQUÍ ES QUE NO ESTA BANEADO

// time() NOS DEVUELVE LA HORA ACTUAL EN SEGUNDOS Y LO RESTAMOS CON $_SESSION
if(time()-$_SESSION["ult_accion"] > MINUTOS * 60){ // SI EL TIEMPO ES MAYOR SE CIERRA LA SESIÓN
    session_unset();
    $_SESSION["seguridad"] = "El tiempo de sesión ha expirado";
    header("Location: " . $salto);
    exit;
    
}

$_SESSION["ult_accion"] = time();



?>