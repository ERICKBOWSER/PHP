<?php
$datos["usuario"] = $_SESSION["usuario"];
$datos["clave"] = $_SESSION["clave"];
$url = DIR_SERV . "/login";
$respuesta = consumir_servicios_REST($url, "POST", $datos);
$obj =json_decode($respuesta);
if(!$obj){
    session_destroy();
    die(errorPage("App Login SW", "<h1>App Login SW</h1>" . $respuesta));
}

if(isset($obj->mensaje_error)){
    session_destroy();
    die(errorPage("App Login SW", "<h1>App Login SW</h1><p>" . $obj->mensaje_error . "</p>"));
}

if(isset($obj->mensaje)){
    session_unset();
    $_SESSION["seguridad"] = "Usted ya no se encuentra registrado en la BD";
    header("Location:index.php");
    exit;
}

$datosUsuarioLog = $obj->usuario;

if(time()-$_SESSION["ult_accion"]>MINUTOS*60){
    session_unset();
    $_SESSION["seguridad"] = "Su tiempo de sesión ha caducado";
    header("Location:index.php");
    exit;
}

$_SESSION["ult_accion"]=time();

?>