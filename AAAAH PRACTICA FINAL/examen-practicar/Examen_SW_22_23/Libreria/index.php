<?php

// INICIAMOS SESIÓN
session_name("examen-practicar");
session_start();

require "src/funciones_ctes.php";

if(isset($_POST["btnSalir"])){

}

if(isset($_SESSION["usuario"])){
    // Estoy loqueado
}else{
    require "vistas/vistaHome.php";
}
?>
