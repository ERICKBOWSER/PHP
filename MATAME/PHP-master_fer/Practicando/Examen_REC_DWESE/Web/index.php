<?php
session_name("ExamenRec_SW_23_24");
session_start();


require "src/funciones_ctes.php";



if(isset($_POST["btnSalir"])){

    $datos_env["api_session"];
    consumir_servicios_REST(DIR_SERV,"/salir","POST",$datos_env); //datosenv es un array

    session_destroy();
    header("Location:index.php");
    exit();
}


if(isset($_SESSION["usuario"])){
    require "src/seguridad.php";

    require "vistas/vista_examen.php"; //Esto solo pasa porque es una unica vista , no tiene ni admin ni normal

}else{
    require "vistas/vista_login.php";
}
?>
