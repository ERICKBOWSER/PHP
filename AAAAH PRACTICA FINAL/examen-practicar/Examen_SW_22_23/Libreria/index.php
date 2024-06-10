<?php

// INICIAMOS SESIÓN
session_name("examen-practicar");
session_start();

require "src/funciones_ctes.php";

if(isset($_POST["btnSalir"])){
    // Llamamos a salir
    $datos["api_session"] = $_SESSION["api_session"];
    consumir_servicios_REST(DIR_SERV."/salir", "POST", $datos);

    session_destroy();
    header("Location:index.php");
    exit;
}

// Estoy logueado
if(isset($_SESSION["usuario"])){

    $salto = "index.php";
    require("src/seguridad.php"); // Datos de api_session ya lo tengo insertado aquí, no hace falta llamarlo otra vez
    if($datosUsuarioLog->tipo == "normal"){
        require "vistas/vista_normal.php";
    }else{
        header("Location:admin/gest_libros.php");
        exit;
    }         

}else{
    require "vistas/vistaHome.php";
}
?>
