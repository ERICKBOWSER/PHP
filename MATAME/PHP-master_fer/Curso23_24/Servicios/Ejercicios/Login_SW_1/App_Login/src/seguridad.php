<?php
$datos["api_key"]=$_SESSION["api_key"];
$url=DIR_SERV."/logueado";
$respuesta=consumir_servicios_REST($url,"POST",$datos);
$obj=json_decode($respuesta);
if(!$obj)
{
    session_destroy();
    die(error_page("App Login SW","<h1>App Login SW</h1>".$respuesta));
}

if(isset($obj->mensaje_error))
{
    session_destroy();
    die(error_page("App Login SW","<h1>App Login SW</h1><p>".$obj->mensaje_error."</p>"));
}

if(isset($ob->no_login)){
    session_unset();
    $_SESSION["seguridad"]="El tiempo de sesion de la api";
    header("Location:index.php");
    exit;
}

if(isset($obj->mensaje))
{
    session_unset();
    $_SESSION["seguridad"]="Usted ya no se encuentra registrado en la BD";
    header("Location:index.php");
    exit;
}
$datos_usuario_log=$obj->usuario;

if(time()-$_SESSION["ult_accion"]>MINUTOS*60)
{
    session_unset();
    $_SESSION["seguridad"]="Su tiempo de sesión ha caducado";
    header("Location:index.php");
    exit;
}

$_SESSION["ult_accion"]=time();
?>