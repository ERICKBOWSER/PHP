<?php
    // Compruebo errores
    if(isset($_POST["submit"])){
        $error_nombre = $_POST["nombre"] == "";
        $error_ape = $_POST["ape"] == "";
        $error_clave = $_POST["pass"] == "";
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

