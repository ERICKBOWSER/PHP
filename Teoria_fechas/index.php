<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Teoría de fechas</h1>
    <?php
        echo "<p>" . time() ."</p>"; // Te muestra los segundos de una fecha dada

        //  Muestra la hora
        echo "<p>" . date("d/m/Y h:i:s", 2000) ."</p>"; //  i para minutos

        if(checkdate(2, 28, 2023)){
            echo "<p>Fecha buena</p>";
        }else{
            echo "<p>Fecha Mala</p>";
        }

        //  mktime(hora, minuto, seg, mes, dia, año)
        echo "<p>" . date("d/m/Y",mktime(0,0,0,9,23,1976)) . "</p>";//  mktime() te da los sec que han pasado desde la fecha que se le da hasta la actual
        
        echo "<p>" . strtotime("09/23/1976") . "</p>";

        echo "<p>" . floor(6.5) . "</p>";

        echo "<p>" . ceil(6.5) . "</p>";

        printf("<p>%.2f</p>", 5.6666*7.8888);

        $resultado = printf("<p>%.2f</p>", 5.6666*7.8888); // No lo muestra, guarda el string de eso

        echo $resultado;

        for ($i=0; $i <= 20; $i++) { 
            # code...

            echo "<p>" . sprintf("%03d", $i) . "</p>"; //  Cadena de string
        }


    ?>
</body>
</html>

