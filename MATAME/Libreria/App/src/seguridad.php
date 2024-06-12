<?php
$datos_env["api_session"]=$_SESSION["api_session"]; // ESTO LO PILLAMOS DE LA FUNCIÓN /login
$respuesta=consumir_servicios_REST(DIR_SERV."/logueado", "GET", $datos_env);
$json=json_decode($respuesta, true);

if(!$json){
    session_destroy();
    die(error_page("Examen libreria", "<h1>Libreria</h1><p>Error en seguridad</p>"));
}

if(isset($json["error"])){
    session_destroy();
    // OBLIGATORIO EN SEGURIDAD LLAMAR AL SERVICIO, EN VISTAS NO SE LLAMA
    consumir_servicios_REST(DIR_SERV."/salir", "POST", $datos_env);
    die(error_page("Examen libreria", "<h1>Libreria</h1><p>Error en seguridad: Error".$json["error"]."</p>"));
}

if(isset($json["no_auth"])){
    session_unset();
    $_SESSION["seguridad"]="Usted ha dejado de tener acceso a la API. Por favor vuelva a loguearse.";
    header("Location:index.php");
    exit();
}


if(isset($json["mensaje"])){
    session_unset();
    consumir_servicios_REST(DIR_SERV."/salir", "POST", $datos_env);
    $_SESSION["seguridad"]="Usted ya no se encuentra registrado en la BD.";
    header("Location:index.php");
    exit();
}

// PASAMOS EL CONTROL DE BANEO
$datos_usuario_log=$json["usuario"];

// AHORA EL CONTROL DE TIEMPO
if(time()-$_SESSION["ult_accion"]>MINUTOS*60){
    session_unset();
    consumir_servicios_REST(DIR_SERV."/salir","POST", $datos_env);
    $_SESSION["seguridad"]="Su tiempo de sesión ha expirado. Por favor vuelva a loguearse.";
    header("Location:index.php");
    exit();
}

// PASAMOS EL CONTROL DE TIEMPO Y RENOVAMOS
$_SESSION["ult_accion"]=time();

?>