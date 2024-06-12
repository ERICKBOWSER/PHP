<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio8</title>
</head>
<body>
    <?php

        $arr=array('Pedro','Ismael','Sonia','Clara','Susana','Alfonso','Teresa');

        echo "<p>El array tiene ".count($arr)." elementos</p>";
        echo "<ul>";
        foreach ($arr as $indice => $valor) {

            echo "<li>".$valor."</li>";
            
        }

        echo "</ul>";

    ?>
    
</body>
</html>