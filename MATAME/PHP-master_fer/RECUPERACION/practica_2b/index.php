<?php
session_name("Examen3Libreria");
session_start();

require "src/funct_ctes.php";

if (isset($_POST["btnSalir"])) {
    session_destroy();
    header("Location:index.php");
    exit;
}


try {
    $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
} catch (PDOException $e) {
    session_destroy();
    die(error_page("Práctica Rec 2", "<h1>Práctica Rec 2</h1><p>Imposible conectar a la BD. Error:" . $e->getMessage() . "</p>"));
}


if (isset($_SESSION["usuario"])) {
    $salto = "index.php";
    require "src/seguridad.php";

    if ($datos_usuario_log["tipo"] == "normal") {
        require "vistas/vista_normal.php";
    } else {
        header("Location:admin/gest_libros.php");
        exit;
    }
    $conexion = null;
} else {
    require "vistas/vista_home.php";
}
