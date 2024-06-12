<?php

    function en_array($valor,$arr) //Esta funcion mira en el array que hemos puesto en el campo de aficiones (aficiones[] asi se crea el array)
    {                              //Y lo recorre para saber si esta un valor determinado si esta ese valor devuelve true 
        $esta=false;

        for ($i=0;$i<count($arr);$i++) { 

            if($arr[$i]==$valor){

                $esta=true;
                break;
            }
        }

        return $esta;

    }

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