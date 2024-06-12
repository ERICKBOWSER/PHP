<?php
session_name("examen_colegio");
session_start();

require "../src/funciones_ctes.php";

if(isset($_SESSION["usuario"])){
    $salto="../index.php";
    require "../src/seguridad.php";
    if($datos_usuario_log["tipo"]=="tutor"){
        require "../vistas/vista_admin.php";
    }else{
        header("Location:..index.php");
        exit();
    }
}else{
    header("Location:../index.php");
    exit();
}


?>