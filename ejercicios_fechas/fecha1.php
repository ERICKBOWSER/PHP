<?php

    function buenosSeparadores($fecha){
        return substr($fecha, 2, 1) == "/" && substr($fecha, 5, 1) == "/";
    }

    function buenosNumeros($fecha){
        return is_numeric(substr($fecha, 0, 2)) && is_numeric(substr($fecha, 3, 2)) && is_numeric(substr($fecha, 6, 4));
    }

    function fechaValida($fecha){
        return checkdate(substr($fecha, 3, 2), substr($fecha, 0, 2), substr($fecha, 6, 4));
    }

    if(isset($_POST["calcular"])){
        $errorFecha1 = $_POST["fecha1"] == "" || $_POST["fecha1"] != 10 || !buenosNumeros($_POST["fecha1"]) 
            || !buenosSeparadores($_POST["fecha1"]) || !fechaValida($_POST["fecha1"]);

        $errorFecha2 = $_POST["fecha1"] == "" || $_POST["fecha1"] != 10 || !buenosNumeros($_POST["fecha1"]) 
            || !buenosSeparadores($_POST["fecha1"]) || !fechaValida($_POST["fecha1"]);

        $errorForm = $errorFecha1 || $errorFecha2;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fecha 1</title>
    <style>
        .cuadro{border:solid; padding: 5px}
        .fondoCeleste{background-color: lightblue}
        .fondoVerdoso{background-color: green}
        .centro{text-align: center}
        .error{color:red}
    </style>
</head>
<body>
    <h1>Fechas - Formulario</h1>

    <form action="fecha1.php" method="post" enctype="multipart/form-data">
        <p>
            <label for="fecha1">fecha1=>Introduzca una fecha: (DD/MM/YYYY)</label>
            <input type="text" name="fecha1" id="fecha1"/>
            <?php
                if(isset($_POST["calcular"]) && $errorFecha1){
                    if($_POST["fecha1"] == ""){
                        echo "<p class='error'>Campo vacío</p>";
                    }else{
                        echo "<p class='error'>Fecha no valida</p>";
                    }
                }
            ?>
            <br/>
            <label for="fecha2">fecha1=>Introduzca una fecha: (DD/MM/YYYY)</label>
            <input type="text" name="fecha2" id="fecha2"/>
            <?php
                if(isset($_POST["calcular"]) && $errorFecha2){
                    if($_POST["fecha2"] == ""){
                        echo "<p class='error'>Campo vacío</p>";
                    }else{
                        echo "<p class='error'>Fecha no valida</p>";
                    }
                }
            ?>
        </p>    
        <p>
            <button type="submit" name="calcular" id="calcular">Calcular</button>
        </p>
    </form>
</body>
</html>
<?php
    if(isset($_POST["calcular"]) && !$errorForm){
        // le quitamos las barras para poder convertirlo en una fecha
        $fecha1 = explode("/", $_POST["fecha1"]);
        $fecha2 = explode("/", $_POST["fecha2"]);

        //$convertir1 = strtotime($fecha1[1] . "/" . $fecha1[0] . "/" . $fecha1[2]);

        // Convertimos el texto en fechas
        $convertir1 = mktime(0,0,0, $fecha1[1], $fecha1[0], $fecha1[2]);
        $convertir2 = mktime(0,0,0, $fecha2[1], $fecha2[0], $fecha2[2]);

        var_dump($convertir1);
        var_dump($convertir2);

        // Con abs hace que no se devuelva un valor negativo
        $difSegundos = abs($convertir1 - $convertir2);

        $diasPasados = floor($difSegundos / (60 * 60 * 24));

        echo "<div class='cuadro fondoVerdoso'>";
            echo "<h1 class='centro'>Fechas - Respuesta</h1>";
            echo "<p>La diferencia de días entre las dos fechas introducidas es de " . $diasPasados;
        echo "</div>";


    }

?>