<?php
    $errorFormu = false;

    if (isset($_POST["enviar"])) {
        
    //SI LOS CAMPOS DE REQUERIDO SE PONEN VACIOS
        $errorNombre = $_POST["nombre"] == "";
        $errorSexo = !isset($_POST["sexo"]);

        $errorFormu = $errorNombre || $errorSexo;
    }

    //SI NO TIENE ERRORES Y SE PULSA EL BOTON

    if (isset($_POST["enviar"]) && !$errorFormu) {
        require "vistas/vistasRespuestas.php";
    }else{
        require "vistas/vistasFormulario.php";
    }
?>