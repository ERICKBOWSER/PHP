<?php
session_name("Examen3_Pract_Rec_23_24");
session_start();

require "../src/funciones_ctes.php";



if(isset($_SESSION["usuario"]))
{
    $salto="../index.php";
    require "../src/seguridad.php";

    if($datos_usuario_log["tipo"]=="admin")

        require "vistas/vista_admin.php";
    else
    {
        $conexion=null;
        header("Location:".$salto);
        exit;
    }

    $conexion=null;

}
else
{
    header("Location:../index.php");
    exit;
}

