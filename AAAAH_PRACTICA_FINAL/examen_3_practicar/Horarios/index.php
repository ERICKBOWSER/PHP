<?php

session_name("examen3_practicar");
session_start();

require("src/funciones_ctes.php");

// EL LOGIN NOS DEVUELVE EL api_session

if(isset($_POST["btnSalir"])){
    $datos["api_session"] = $_SESSION["api_session"];
    consumir_servicios_REST(DIR_SERV . "/salir", "POST", $datos);

    session_destroy();
    header("Location: index.php");
    exit;
}

if(isset($_SESSION["usuario"])){
    // SIEMPRE SE PASA PRIMERO POR SEGURIDAD
    require("src/seguridad.php");

    if($datos_usuario_log->tipo == "normal"){
        require "vistas/vista_normal.php";
    }else{
        require "vistas/vista_home.php";
    }
}else{
    require "vistas/vista_home.php";
}



?>