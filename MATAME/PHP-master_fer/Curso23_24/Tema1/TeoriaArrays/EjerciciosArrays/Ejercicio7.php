<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio7</title>
</head>
<body>

    <?php

        $arr['MD']='Madrid';
        $arr['BC']='Barcelona';
        $arr['LD']='Londres';
        $arr['NY']='New York';
        $arr['LA']='Los Angeles';
        $arr['CG']='Chicago';


        foreach ($arr as $indice => $valores) {
            echo "<p>La ciudad con el indice ".$indice." tiene el nombre de: ".$valores."</p>";
        }

        
    ?>
    
</body>
</html>