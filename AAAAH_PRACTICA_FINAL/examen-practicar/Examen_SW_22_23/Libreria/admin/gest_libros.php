<?php
    session_name("examen-practicar");
    session_start();

    require "../src/funciones_ctes.php";
    if(isset($_SESSION["usuario"])){
        $salto = "../index.php"; // PARA QUE NO HAYA PROBLEMAS CON seguridad.php

        require "../src/seguridad.php";
        if($datosUsuarioLog -> tipo == "admin"){
            require "../vistas/vista_admin.php";
        }else{
            header("Location:" . $salto);
            exit;
        }
    }else{
        header("Location: ../index.php");
        exit;
    }

?>


