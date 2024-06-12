<?php
session_name("examen3_23_24");
session_start();

require "src/funct_ctes.php";

if(isset($_POST["btnSalir"]))
{
    session_destroy();
    header("Location:index.php");
    exit;
}


try{
    $conexion=mysqli_connect(SERVIDOR_BD,USUARIO_BD,CLAVE_BD,NOMBRE_BD);
    mysqli_set_charset($conexion,"utf8");
}
catch(Exception $e)
{
    session_destroy();
    die(error_page("Examen3 Curso 23-24","<h1>Librería</h1><p>No he podido conectarse a la base de batos: ".$e->getMessage()."</p>"));
}



if(isset($_SESSION["usuario"]))
{
    $salto="index.php";
    require "src/seguridad.php";

    if($datos_usuario_logueado["tipo"]=="normal")
    {
        require "vistas/vista_normal.php";
    }
    else
    {
        header("Location:admin/gest_libros.php");
        exit;
    }

}
else
{
    require "vistas/vista_home.php";    

}

mysqli_close($conexion);

?>