<?php
session_name("Examen_Horarios_SW");
session_start();

require "src/funciones_ctes.php";

if(isset($_POST["btnSalir"]))
{
    $datos["api_session"]=$_SESSION["api_session"];
    consumir_servicios_REST(DIR_SERV."/salir","POST",$datos);
    session_destroy();
    header("Location:index.php");
    exit;
}

if(isset($_SESSION["usuario"]))
{
    require "src/seguridad.php";

    if($datos_usuario_log->tipo=="normal")
        require "vistas/vista_normal.php";
    else
        require "vistas/vista_admin.php";
}
else
{
    require "vistas/vista_home.php";
}
?>
