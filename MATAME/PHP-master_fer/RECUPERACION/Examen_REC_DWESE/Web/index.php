<?php
session_name("ExamenRec_SW_23_24");
session_start();

require "./src/func_const.php";

if(isset($_POST["btnSalir"])){
    $datos["api_session"] = $_SESSION["api_session"];
    consumir_servicios_REST(DIR_SERV."/salir","POST",$datos);
    session_destroy();
}

if(isset($_SESSION["usuario"])){
    require "./src/seguridad.php";

    require "./vistas/vista_guardia.php";

}else{
    require "./vistas/vista_home.php";
}

?>
