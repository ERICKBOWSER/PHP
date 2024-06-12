<?php

$datos_env["api_session"]=$_SESSION["api_session"];
$respuesta = consumir_servicios_REST(DIR_SERV."/logueado","GET",$datos_env);
$json = json_decode($respuesta,true);


if(!$json){

    session_destroy();
    die(error_page("Examen","<h1>Examen</h1><p>Error al consumir la api</p>"));
}



if(isset($json["error_bd"])){
    session_destroy();
    consumir_servicios_REST(DIR_SERV."/salir","POST",$datos_env);
    die(error_page("Examen","<h1>Examen</h1><p>".$json["error_bd"]."</p>"));
}


if(isset($json["no_auth"])){
 
    session_unset();
    $_SESSION["seguridad"]="Has dejado de tener acceso a esta api";
    header("Location:index.php");
    exit();
}


if(isset($json["mensaje"])){

    session_unset();
    consumir_servicios_REST(DIR_SERV."/salir","POST",$datos_env);
    $_SESSION["seguridad"]="Usted ya no se encuentra registrado en la bd";
    header("Location:index.php");
    exit();
}

$datos_usuario_log=$json["usuario"];


if(time()-$_SESSION["ultima_accion"]>MINUTOS*60){

    session_unset();
    consumir_servicios_REST(DIR_SERV."/salir","POST",$datos_env);
    $_SESSION["seguridad"]="Usted ya no se encuentra registrado en la bd";
    header("Location:index.php");
    exit();
}

$_SESSION["ultima_accion"]=time();

?>