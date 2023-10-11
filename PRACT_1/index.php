<?php

    require "vistas/vista_formulario.php";

    // Detectar la letra del dni
    function letraNIF($dni){
        return substr("TRWAGMYFPDXBNJZSQVHLCKEO", $dni % 23, 1);
    }

    function dniBienEscrito($texto){
        return strlen($texto) == 9 && is_numeric(substr($texto, 0, 8)) && 
            substr($texto, -1) >= "A" && substr($texto, -1) <= "Z";
    }

    function dniValido($texto){
        $numero = substr($texto, 0, 8);
        $letra = substr($texto, -1);
        $valido = letraNIF($numero) == $letra;

        return $valido;
    }

    // Guardar imagen

    if(isset($_POST["submit"])){
        // Comprueba si hay algún error en la imagen
        $errorArchivo = $_FILES["archivo"]["name"] == ""
            || $_FILES["archivo"]["error"]
            || !getimagesize($_FILES["archivo"]["tmp_name"])
            || $_FILES["archivo"]["size"] > 500 * 1024;
    }

    // Boton de borrar
    if(isset($_POST["btnBorrar"])){
        // destruye el post
        unset($_POST);

        // 2da forma 
        // header("Location: index.php");
        // exit; // para que no haga nada más

    }

    // Compruebo errores
    if(isset($_POST["submit"])){
        $error_nombre = $_POST["nombre"] == "";
        $error_ape = $_POST["ape"] == "";
        $error_clave = $_POST["pass"] == "";

        $error_dni = $_POST["dni"] == "" || !dniBienEscrito(strtoupper($_POST["dni"])) || 
                !dniValido(strtoupper($_POST["dni"]));

        $error_sexo = !isset($_POST["sexo"]) == "";
        $error_comentarios = $_POST["comentario"];

        // Archivos
        $errorArchivo = $_FILES["archivo"]["name"] != "" && ($_FILES["archivo"]["error"] || !getimagesize($_FILES["archivo"]["tmp_name"]) || $_FILES["archivo"]["size"] > 500 * 1024);

        $error_form = $error_nombre || $error_ape || 
        $error_clave || $error_sexo || $error_comentarios;

    }
    if(isset($_POST["submit"]) && !$error_form){

        require "vistas/vista_formulario.php";
    }else{
        require "vistas/vista_respuesta.php";
    }


?>

