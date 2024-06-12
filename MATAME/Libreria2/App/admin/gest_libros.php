<?php
session_name("libreria_SW");
session_start();

require "../src/funciones_ctes.php";

if(isset($_SESSION["usuario"])){
    $salto="../index.php";
    require "../src/seguridad.php";

    if($datos_usuario_log["tipo"]=="admin"){
        require "vistas/vista_admin.php";
    }else{
        header("Location:".$salto);
        exit();
    }
}else{
    header("Location: ..index.php");
    exit;
}



?>