<?php
session_name("App_Login_Key_23_24");
session_start();

require "src/funcione_ctes.php";

if (isset($_POST["btnSalir"])) {

    $datos["api_key"] = $_SESSION["api_key"];
    $url = DIR_SERV . "/logueado";
    $respuesta = consumir_servicios_REST($url, "POST", $datos);
    session_destroy();
    header("Location:index.php");
    exit;
}



if (isset($_SESSION["usuario"])) {

    require "src/seguridad.php";


    if ($datos_usuario_log->tipo == "normal")
        require "vistas/vista_normal.php";
    else
        require "vistas/vista_admin.php";
} else {
    require "vistas/vista_home.php";
}
