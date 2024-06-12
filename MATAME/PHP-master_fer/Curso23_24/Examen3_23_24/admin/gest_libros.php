<?php
session_name("examen3_23_24");
session_start();

require "../src/funct_ctes.php";

if(isset($_POST["btnSalir"]))
{
    session_destroy();
    header("Location:../index.php");
    exit;
}



if(isset($_SESSION["usuario"]))
{
    $salto="../index.php";

    try{
        $conexion=mysqli_connect(SERVIDOR_BD,USUARIO_BD,CLAVE_BD,NOMBRE_BD);
        mysqli_set_charset($conexion,"utf8");
    }
    catch(Exception $e)
    {
        session_destroy();
        die(error_page("Examen3 Curso 23-24","<h1>Librería</h1><p>No he podido conectarse a la base de batos: ".$e->getMessage()."</p>"));
    }

    require "../src/seguridad.php";
    
    if($datos_usuario_logueado["tipo"]=="admin")
    {
        require "../vistas/vista_admin.php";
    }
    else
    {
        header("Location:../index.php");
        exit;
    }
}
else
{
    header("Location:../index.php");
    exit();
}