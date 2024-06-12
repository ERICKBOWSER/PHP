<?php
session_start();

$datos_env["api_session"]=$_SESSION["api_session"];
$url=DIR_SERV."/logueado";
$respuesta=consumir_servicios_REST($url, "GET", $datos_env);
$json=json_decode($respuesta, true);

if(!$json){
    session_destroy();
    die(error_page("Libreria","<h1>Libreria</h1><p>Error al consumir el servicio en seguridad. ".$url."</p>"));
}

if(isset($json["error"])){
    session_destroy();
    die(error_page("Libreria", "<h1>Libreria</h1><p>".$json["error"]."</p>"));
}

if(isset($json["no_auth"])){
    session_unset();
    $_SESSION["seguridad"]="Usted ya no esta logueado";
    header("Location: index.php");
    exit();
}

if(isset($json["mensaje"])){
    session_unset();
    consumir_servicios_REST(DIR_SERV."/salir", "POST", $datos_env);
    $_SESSION["seguridad"]="Usted ya no se encuentra registrado en la BD";
    header("Location:index.php");
    exit();
}

// PASAMOS EL BANEO
$datos_usuario_log=$json["usuario"];

// CONTROL DE TIEMPO
if(time()-$_SESSION["ult_accion"]>MINUTOS*60){
    session_unset();
    consumir_servicios_REST(DIR_SERV."/salir", "POST", $datos_env);
    $_SESSION["seguridad"]="Su tiempo de sesión ha expirado. Por favor vuelva a loguearse.";
    header("Location: index.php");
    exit;
}

// RENOVAMOS EL TIEMPO
$_SESSION["ult_accion"]=time();

?>