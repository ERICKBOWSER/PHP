<?php

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

        $error_form = $error_nombre || $error_ape || 
        $error_clave || $error_sexo || $error_comentarios;

    }
    if(isset($_POST["submit"]) && !$error_form){

        require "vistas/vista_formulario.php";
?>
    

<?php
    }else{
        require "vistas/vista_respuesta.php";
?>

<?php
    }


?>

