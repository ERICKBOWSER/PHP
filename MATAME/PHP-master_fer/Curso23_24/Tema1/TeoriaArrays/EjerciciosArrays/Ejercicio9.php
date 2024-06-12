<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio9</title>
    <style> table,td,th{border:1px solid black;} </style>
</head>
<body>

    <?php

        $lenguajes_cliente['M65D']='lenguajeC1';
        $lenguajes_cliente['B23C']='lenguajeC2';
        $lenguajes_cliente['L61D']='lenguajeC3';

        $lenguajes_servidor['N89Y']='lenguajeS1';
        $lenguajes_servidor['L37A']='lenguajeS2';
        $lenguajes_servidor['C92G']='lenguajeS3';

        $lenguajes=array();
        $lenguajes=array_merge($lenguajes_cliente,$lenguajes_servidor);


        echo "<table>";

        foreach ($lenguajes as $indice => $valores) {
            
            echo "<tr>";
            echo "<td>";
            echo $valores;
            echo "</td>";
            echo "</tr>";
        }

        echo "</table>";
        

    ?>
    
</body>
</html>