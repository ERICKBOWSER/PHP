<?php
// Comprobamos si sigue logueado
$url = DIR_SERV . "/logueado";
$datos["api_session"] = $_SESSION["api_session"];
$respuesta = consumir_servicios_REST($url, "POST", $datos);
$obj = json_decode(($respuesta));
if(!$obj){
    session_destroy();
    die(errorPage("Examen", "<h1>Librería</h1><p>Error consumiendo el servicio: " . $url . "</p>"));
}

if(isset($obj->error)){
    session_destroy();
    die(errorPage("Examen", "<h1>Librería</h1><p>" . $obj->error . "</p>"));
}

if(isset($obj-> no_auth)){
    // El tiempo de sessión ha terminado, obligamos a que se loguee
    session_unset();
    $_SESSION["seguridad"] = "El tiempo de sesión de la api ha caducado";
    header("Location:" . $salto);
    exit;
}

// Estoy baneado
if(isset($obj->mensaje)){
    // Me han baneado
    session_unset();
    $_SESSION["seguridad"] = "Usted ya no se encuentra registrado en la BD";
    header("Location:" . $salto);
    exit;
}

$datosUsuarioLog = $obj -> usuario; // SI SE HA PASADO TODO ESTO ES QUE NO ESTA BANEADO
if(time()-$_SESSION["ult_accion"] > MINUTOS*60){
    // Se me ha ido el tiempo
    session_unset();
    $_SESSION["seguridad"] = "El tiempo de sesión ha expirado";
    header("Location:" . $salto);
    exit;
}

// No se ha terminado el tiempo y renovamos el tiempo
$_SESSION["ult_accion"] = time();


?>