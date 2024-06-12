<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio6</title>
</head>
<body>
    <?php

        $arr[]='Madrid';
        $arr[]='Barcelona';
        $arr[]='Londres';
        $arr[]='New York';
        $arr[]='Los Angeles';
        $arr[]='Chicago';

        
        foreach ($arr as $indice => $valores) {
            echo "<p>La ciudad con el indice ".$indice." tiene el nombre de: ".$valores."</p>";
        }

    ?>
</body>
</html>