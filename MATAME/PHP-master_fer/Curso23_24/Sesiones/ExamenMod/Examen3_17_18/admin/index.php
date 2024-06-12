<?php
session_name("Examen3_17_18");
session_start();
require "../src/func_ctes.php";

if(isset($_SESSION["usuario"]))
{
    $salto="../index.php";
    require "../src/seguridad.php";
    if($datos_usuario_logueado["tipo"]=="admin")
        require "../vistas/vista_admin.php";
    else
    {
        mysqli_close($conexion);
        header("Location:".$salto);
        exit;
    }
    mysqli_close($conexion);
}
else
{
    header("Location:../index.php");
    exit;
}
?>
