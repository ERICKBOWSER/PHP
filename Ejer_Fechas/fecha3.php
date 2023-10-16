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
        $errorFecha1 = $_POST["fecha1"] == "";
        $errorFecha2 = $_POST["fecha2"] == "";

        $errorForm = $errorFecha1 || $errorFecha2;


        
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

    <form action="fecha3.php" method="post">
        <p>
            <label for="fecha1">Introduzca una fecha: </label>
            <input type="date" name="fecha1" id="fecha1" value="<?php if(isset($_POST["fecha1"])) echo $_POST["fecha1"];?>"/>
        
            <?php
                if(isset($_POST["btnCalcular"]) && $errorFecha1){
                    if($_POST["fecha1"] == ""){
                        echo "<span class='error'>No has seleccionado una fecha</span";
                    }
                }
            ?>
        </p>
        <p>
            <label for="fecha2">Introduzca una fecha:</label>
            <input type="date" name="fecha2" id="fecha2" value="<?php if(isset($_POST["fecha2"])) echo $_POST["fecha2"];?>"/>
            <?php
                if(isset($_POST["btnCalcular"]) && $errorFecha2){
                    if($_POST["fecha2"] == ""){
                        echo "<span class='error'>No has seleccionado una fecha</span";
                    }
                }
            ?>
        </p>
        
        <button type="submit" name="btnCalcular" id="btnCalcular">Calcular</button>
    </form>
    </div>
    <?php
        if(isset($_POST["btnCalcular"]) && !$errorForm){
            //  Le llega una fecha
            $tiempo1 = strtotime($_POST["fecha1"]);
            $tiempo2 = strtotime($_POST["fecha2"]);

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