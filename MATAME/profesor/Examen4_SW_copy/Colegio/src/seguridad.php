<?php

$datos_env["api_session"]=$_SESSION["api_session"];
$respuesta=consumir_servicios_REST(DIR_SERV."/logueado", "GET", $datos_env);
$json=json_decode($respuesta, true);
if(!$json){
   session_destroy();
   die(error_page("Examen4", "<h1>Notas de los alumnos</h1><p>Sin respuesta oportuna de la API.</p>"));
}

if(isset($json["error"])){
   session_destroy();
   consumir_servicios_REST(DIR_SERV."/salir", "POST", $datos_env);
   die(error_page("Examen4", "<h1>Notas de los alumnos</h1><p>".$json["error"]."</p>"));
}

if(isset($json["no_auth"])){
   session_unset();
   $_SESSION["seguridad"]="Usted ha dejado de tener acceso a la API. Por favor vuelva a loguearse";
   header("Location:".$salto);
   exit();
}

if(isset($json["mensaje"])){
   session_unset();
   consumir_servicios_REST(DIR_SERV."/salir", "POST", $datos_env);
   $_SESSION["seguridad"]="Usted ya no se encuentra registrado en la BD";
   header("Location:".$salto);
   exit();
}

// PASAMOS EL CONTROL DE BANEO
$datos_usuario_log=$json["usuario"];

// CONTROL DE TIEMPO
if(time()-$_SESSION["ult_accion"]>MINUTOS*60){
   session_unset();
   consumir_servicios_REST(DIR_SERV."/salir", "POST", $datos_env);
   $_SESSION["seguridad"]="Su tiempo de sesión ha expirado";
   header("Location:".$salto);
   exit();
}

$_SESSION["ult_accion"]=time();
?>



