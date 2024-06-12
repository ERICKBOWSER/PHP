<?php
session_name("libreria_SW");
session_start();

require "src/funciones_ctes.php";

if(isset($_POST["btnSalir"])){
    consumir_servicios_REST(DIR_SERV. "/salir", "POST", $datos_env);
    header("Location:index.php");
    exit();
}

if(isset($_SESSION["usuario"])){
    require "src/seguridad.php";

    if($datos_usuario_log["tipo"]=="admin"){
        require "vistas/vista_normal.php";
    }else{
        header("Location:admin/gest_libros.php");
        exit();
    }
}else{
    require "vistas/vista_home.php";
}


?>