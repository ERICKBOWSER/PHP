<?php
    session_name("pract2");

    session_start();
    require "src/funciones_ctes.php";

    if(isset($_POST["btnSalir"])){
        session_destroy();
        header("Location: index.php");
        exit();
    }

    if(isset($_SESSION["usuario"])){

        require "src/seguridad.php";

        if($datos_usuario_log["tipo"] == "normal"){
            require "vistas/vista_normal.php";
        }else{
            require "vistas/vista_admin.php";
        }

        $conexion=null;
        

    }elseif(isset($_POST["btnRegistrarse"])){    
        require "vistas/vista_registro.php";
    }else{
        require "vistas/vista_home.php";
    }


?>