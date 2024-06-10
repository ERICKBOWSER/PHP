<?php
$datos_env["api_key"]=$_SESSION["api_key"]; // DONDE SE DEFINE EL VALOR DE ESTO?!
$respuesta=consumir_servicios_REST(DIR_SERV."/logueado", "POST", $datos_env);
$json=json_decode($respuesta, true);

if(!$json){
    session_destroy();
    die(error_page("Examen 3", "<h1>Práctica 3</h1><p>Sin respuesta oportuna de la API desde SEGURIDAD</p>"));
}

if(isset($json["error_bd"])){
    session_destroy();
    consumir_servicios_REST(DIR_SERV."/salir", "POST", $datos_env);
    die(error_page("Practica 3", "<h1>Practica 3</h1><p>".$json["error_bd"]."</p>"));
}

if(isset($json["no_auth"])){
    session_unset();
    $_SESSION["seguridad"]="Usted ha dejado de tener acceso a la API. Por favor vuelva a loguearse desde SEGURIDAD";
    header("Location:index.php");
    exit();
}

if(isset($json["mensaje"])){
    session_unset();// PARA QUE SE MUESTRE EL $_SESSION DE ABAJO
    consumir_servicios_REST(DIR_SERV."/salir","POST", $datos_env);
    $_SESSION["seguridad"]="usted ya no se encuentra registrado en al BBDD desde SEGURIDAD";
    header("Location:index.php");
    exit();
}

// PASAMOS EL CONTROL DE BANEOS Y LE PASAMOS EL JSON DEL USUARIO
$datos_usuario_log=$json["usuario"];

// PASAMOS EL CONTROL DE TIEMPO
if(time()-$_SESSION["ultm_accion"]>MINUTOS*60){
    session_unset();
    $_SESSION["seguridad"]="Su tiempo de sesión ha expirado. Por favor vuelva a loguearse.";
    header("Location:index.php");
    exit();
}

// PASO EL CONTROL DE TIEMPO Y RENUEVO
$_SESSION["ultm_accion"]=time();
?>


