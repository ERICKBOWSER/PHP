<?php
$url = DIR_SERV . "/logueado";
$datos["api_session"] = $_SESSION["api_session"];
$respuesta=consumir_servicios_REST($url, "GET", $datos);
$obj = json_decode($respuesta);
if(!$obj){
    session_destroy();
    die(error_page("Examen 3", "<h1>Examen 3</h1><p>Error consumiendo el servicio en SEGURIDAD: " . $url . "</p>"));
}

if(isset($obj->error)){
    session_destroy();
    die(error_page("Examen 3", "<h1>Examen 3 en SEGURIDAD</p>" . $obj->error . "</p>"));
}

if(isset($obj->no_auth)){
    session_unset();
    $_SESSION["seguridad"] = "El tiempo de sesión de la API ha caducado en SEGURIDAD";
    header("Location:index.php");
    exit;
}

// BANEADO
if(isset($obj->mensaje)){
    session_unset();
    $_SESSION["seguridad"] = "Usted ya no se encuentra registrado en la BD";
    header("Location: index.php");
    exit;
}

$datos_usuario_log= $obj->usuario;

if(time()-$_SESSION["ult_accion"] > MINUTOS * 60){
    session_unset();
    $_SESSION["seguridad"] = "Su tiempo de sesión ha expirado";
    header("Location: index.php");
    exit;
}

$_SESSION["ult_accion"] = time(); // EN EL PRIMER INICIO SE HACE require DESDE INDEX Y ASÍ LE ASIGNAMOS UN VALOR, SI PARA LA SIGUIENTE CONSULTA
    // EL USUARIO SIGUE CON TIEMPO SE RENUEVA, PERO SI LA RESTA DA 0 O MENOS EL USUARIO SALE DE LA SESIÓN

?>