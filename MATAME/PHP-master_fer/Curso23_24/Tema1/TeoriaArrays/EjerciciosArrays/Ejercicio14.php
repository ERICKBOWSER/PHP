<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio14</title>
    <style> table,td,th{border:1px solid black;} </style>
</head>
<body>

    <?php

        $estadios_futbol =array("Barcelona" => "Camp Nou","Real Madrid" => "Santiago Bernabeu","Valencia" => "Mestalla","Real Sociedad" => "Anoeta");

        echo "<table>";

        echo "<tr>";

        foreach ($estadios_futbol as $indice => $valor) {
            echo "<td>";
            echo $indice;
            echo "</td>";
        }

        echo "</tr>";
        echo "<tr>";

        foreach ($estadios_futbol as $indice => $valor) {
            echo "<td>";
            echo $valor;
            echo "</td>";
        }

        echo "</tr>";

        echo "</table>";

        echo "<br/>";

        $estadios_futbol2 =array("Barcelona" => "Camp Nou","Real Madrid" => "","Valencia" => "Mestalla","Real Sociedad" => "Anoeta");

        echo "<table>";

        echo "<tr>";

        foreach ($estadios_futbol2 as $indice => $valor) {
            echo "<td>";
            echo $indice;
            echo "</td>";
        }

        echo "</tr>";
        echo "<tr>";

        foreach ($estadios_futbol2 as $indice => $valor) {
            echo "<td>";
            echo $valor;
            echo "</td>";
        }

        echo "</tr>";

        echo "</table>";


    ?>
    
</body>
</html>