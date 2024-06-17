<?php
$datos_env["api_session"]=$_SESSION["api_session"];
$url=DIR_SERV."/logueado";
$respuesta=consumir_servicios_REST($url, "GET", $datos_env);
$json=json_decode($respuesta, true);
if(!$json){
    session_destroy();
    die(error_page("Examen final", "<h1>Examen final PHP</h1><p>Error consumiendo los servicios desde seguridad: ".$url."</p>"));
}
if(isset($json["error"])){
    session_destroy();
    consumir_servicios_REST(DIR_SERV."/salir", "POST", $datos_env);
    die(error_page("Examen final", "<h1>Examen final PHP</h1><p>".$json["error"]."</p>"));
}

if(isset($json["no_auth"])){
    session_unset();
    $_SESSION["seguridad"]="Usted ya no se encuentra logueado desde seguridad";
    header("Location:index.php");
    exit;
}

if(isset($json["mensaje"])){
    session_unset();
    consumir_servicios_REST(DIR_SERV."/salir", "POST", $datos_env);
    $_SESSION["seguridad"]="Usted ya no se encuentra registrado en la BBDD";
    header("Location:index.php");
    exit();
}

$datos_usuario_log=$json["usuario"];

if(time()-$_SESSION["ult_accion"]>MINUTOS*60){
    session_unset();
    consumir_servicios_REST(DIR_SERV."/salir", "POST", $datos_env);
    $_SESSION["seguridad"]="Tiempo de sesion sobrepasado";
    header("Location:index.php");
    exit;
}

$_SESSION["ult_accion"]=time();
?>