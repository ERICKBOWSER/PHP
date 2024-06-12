<?php
session_name("Practicando");
session_start();
if(isset($_POST["btnSalir"])){


    $datos_env["api_session"];
    consumir_servicios_REST(DIR_SERV."/salir","GET",$datos_env);

    session_destroy();
    header("Location:index.php");
    exit();
}

if(isset($_SESSION["usuario"])){

    

}else{


}
