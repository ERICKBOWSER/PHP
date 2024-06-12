<?php
session_name("Practica_3B_libreria");
session_start();

require "../src/funciones_ctes.php";

if (isset($_SESSION["usuario"])) {
    $salto = "../index.php"; // variable para realizar el salto de seguridad correcto si hay baneo o errores
    require "../src/seguridad.php";

    if ($datos_usuario_log["tipo"] == "admin") //si eres admin
    {
        require "vistas/vista_admin.php"; // entro en las vistas de dentro de admin
    }
       
    else
    {
        
        header("Location:" . $salto);
     exit();
    }
     
} else {
    header("Location:../index.php");
    exit();
}
