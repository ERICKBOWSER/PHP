<?php
$url = DIR_SERV."/logueado";
$datos["api_session"] = $_SESSION["api_session"];
$respuesta = consumir_servicios_REST($url, "GET",$datos);
$obj = json_decode($respuesta);

if(!$obj){
    session_destroy();
    die(error_page("Error","<p>Obj no creado<p>"));
}

if(isset($obj->error)){
    session_destroy();
    consumir_servicios_REST(DIR_SERV."/salir","POST",$datos);
    die(error_page("Error","<p>Error en la API<p>"));
}

// no auth
if(isset($obj->no_auth)){
    session_unset();
    $_SESSION["seguridad"] = "Se ha quedado sin tiempo en la API";
    consumir_servicios_REST(DIR_SERV."/salir","POST",$datos);
    header("Location:index.php");
    exit;
}
// mensaje
if(isset($obj->mensaje)){
    session_unset();
    $_SESSION["seguridad"] = "Usted ya no se encuentra en la base de datos";
    consumir_servicios_REST(DIR_SERV."/salir","POST",$datos);
    header("Location:index.php");
    exit;
}

// datos usu
$datos_usu_log = $obj->usuario;

// comprobar time
if(time()-$_SESSION["ultConex"] > MINUTOS * 60){
    session_unset();
    $_SESSION["seguridad"] = "Se ha agotado su tiempo";
    consumir_servicios_REST(DIR_SERV."/salir","POST",$datos);
    header("Location:index.php");
    exit;
}
//poner time
$_SESSION["ultConex"] = time();

?>