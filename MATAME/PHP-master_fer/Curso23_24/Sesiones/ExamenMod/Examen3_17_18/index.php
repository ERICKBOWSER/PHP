<?php
session_name("Examen3_17_18");
session_start();
require "src/func_ctes.php";

if(isset($_POST["btnSalir"]))
{
    session_destroy();
    header("Location:index.php");
    exit;
}


if(isset($_SESSION["usuario"]))
{
    /// Estoy logueado
    $salto="index.php";
    require "src/seguridad.php";

    if($datos_usuario_logueado["tipo"]=="admin")
    {
        mysqli_close($conexion);
        header("Location:admin/index.php");
        exit;
    }    
    else
    //Vista oportuna
        require "vistas/vista_normal.php";
    
    mysqli_close($conexion);
}
else
{
    require "vistas/vista_login.php";
}


?>