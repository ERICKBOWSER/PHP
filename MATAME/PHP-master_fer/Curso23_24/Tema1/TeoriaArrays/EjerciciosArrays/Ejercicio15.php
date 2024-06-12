<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio15</title>
    <style> table,td,th{border:1px solid black;} </style>
</head>
<body>

    <?php

        $numeros =array(3,2,8,123,5,1);

        sort($numeros);

        echo "<table>";

        foreach ($numeros as $indice => $valor) {
            echo "<tr>";
            echo "<td>";
            echo $valor;
            echo "</td>";
            echo "</tr>";
        }

        echo "</table>";
     

    ?>
    
</body>
</html>