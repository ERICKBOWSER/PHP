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
    require "src/seguridad.php";

    //Vista oportuna
    require "vistas/vista_examen.php";
    
    mysqli_close($conexion);
}
else
{
   
    require "vistas/vista_login.php";


}


?>