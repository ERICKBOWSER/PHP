<?php
session_name("Examen3_Pract_Rec_23_24");
session_start();

require "src/funciones_ctes.php";

if(isset($_POST["btnSalir"]))
{
    $datos_env['api_key']=$_SESSION['api_key'];// Lo creamos antes de destruirlo
    session_destroy();

    consumir_servicios_REST(DIR_SERV."/salir","POST", $datos_env);
    header("Location:index.php");
    exit;
}


if(isset($_SESSION["usuario"]))
{
    $salto="index.php";
    require "src/seguridad.php";

    if($datos_usuario_log["tipo"]=="normal")
        
        require "vistas/vista_normal.php";
    else
    {
        $conexion=null;
        header("Location:admin/gest_libros.php");
        exit;
    }


    $conexion=null;
}
else
{
    require "vistas/vista_home.php";
}

?>