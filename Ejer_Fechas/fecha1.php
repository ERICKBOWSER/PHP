<?php

    function buenosSeparadores($texto){

        return substr($texto, 2, 1) == "/" && substr($texto, 5, 1) == "/";

    }

    function numerosBuenos($texto){
        return is_numeric(substr($texto, 0, 2)) && is_numeric(substr($texto, 3, 2)) && is_numeric(substr($texto, 6, 4));
    }

    function fechaValida($texto){
        return checkdate(substr($texto, 3, 2), substr($texto, 0, 2), substr($texto, 6, 4));
    }


    if(isset($_POST["btnCalcular"])){

        // Compruebo errores
        $errorFecha1 = $_POST["texto1"] == "" || strlen($_POST["texto1"]) != 10 
                || !buenosSeparadores($_POST["texto1"]) || numerosBuenos($_POST["texto1"])|| !fechaValida($_POST["texto1"]);

        $errorFecha2 = $_POST["texto2"] == "" || strlen($_POST["texto2"]) != 10 
                || !buenosSeparadores($_POST["texto2"]) || numerosBuenos($_POST["texto2"]) || !fechaValida($_POST["texto2"]);


        $errorForm =  $errorFecha1 || $errorFecha2;
        
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .cuadro{border:solid; padding:5px}
        .fondoCeleste{background-color: lightblue}
        .fondoVerdoso{background-color: green}
        .centro{text-align: center}
        .error{color:red}
    </style>
</head>
<body>
    <div class="cuadro fondoCeleste">
    <h1>Fechas - Formulario</h1>

    <form action="fecha1.php" method="post">
        <p>
            <label for="texto1">Introduzca una fecha: (DD/MM/YYYY)</label>
            <input type="text" name="texto1" id="texto1" value="<?php if(isset($_POST["texto1"])) echo $_POST["texto1"];?>"/>
        
            <?php
                if(isset($_POST["btnCalcular"]) && $errorFecha1){
                    if($_POST["texto1"] == ""){
                        echo "<span class='error'>Campo vacío</span";
                    }else{
                        echo "<span class='error'>Fecha no valida</span";
                    }
                }
            ?>
        </p>
        <p>
            <label for="texto2">Introduzca una fecha: (DD/MM/YYYY)</label>
            <input type="text" name="texto2" id="texto2" value="<?php if(isset($_POST["texto2"])) echo $_POST["texto2"];?>"/>
            <?php
                if(isset($_POST["btnCalcular"]) && $errorFecha2){
                    if($_POST["texto2"] == ""){
                        echo "<span class='error'>Campo vacío</span";
                    }else{
                        echo "<span class='error'>Fecha no valida</span";
                    }
                }
            ?>
        </p>
        
        <button type="submit" name="btnCalcular" id="btnCalcular">Calcular</button>
    </form>
    </div>
    <?php
        if(isset($_POST["btnCalcular"]) && !$errorForm){
            //  Resuelvo el problema

            $fecha1 = explode("/", $_POST["texto1"]);
            $fecha2 = explode("/", $_POST["texto2"]);

            $tiempo1 = mktime(0,0,0, $fecha1[1], $fecha1[0], $fecha1[2]);
            $tiempo2 = mktime(0,0,0, $fecha2[1], $fecha2[0], $fecha2[2]);

            $tiempoUSA1 = strtotime($fecha1[2] . "/" . $fecha1[1] . "/" . $fecha1[0]);
            $tiempoUSA2 = strtotime($fecha2[2] . "/" . $fecha2[1] . "/" . $fecha2[0]);

            $difSegundos = abs($tiempo1 - $tiempo2);
            $diasPasados = floor($difSegundos / (60 * 60 * 24));

            echo "<div class='cuadro fondoVerdoso'>";
                echo "<h1>Fechas - Respuesta</h1>";
                echo "<p>La diferencia en días entre las dos fechas introducidas es de: " . $diasPasados;
            echo "</div>";
        }
    ?>
</body>
</html>