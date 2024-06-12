<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio16</title>
    <style> table,td,th{border:1px solid black;} </style>
</head>
<body>

    <?php

        $numeros[5]=1;
        $numeros[12]=2;
        $numeros[13]=56;
        $numeros[]=42;

        print_r($numeros);

        unset($numeros[5]);

        echo "<br/>";
     
        print_r($numeros);

        unset($numeros);

    ?>
    
</body>
</html>