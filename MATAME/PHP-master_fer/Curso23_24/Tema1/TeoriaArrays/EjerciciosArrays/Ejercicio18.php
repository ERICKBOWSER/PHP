<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio18</title>
</head>
<body>
    <?php

        $deportes = array("futbol","baloncesto","natacion","tennis");


        for ($i=0; $i < count($deportes); $i++) { 

            echo "<p>En la posicion: ".$i." tiene el valor: ".$deportes[$i]."</p>";

        }

        echo "Contiene un total de ".count($deportes)." valores";

        reset($deportes);

        echo "<br/>";
        echo "<p>Elemento actual en el que esta situado el puntero: ".current($deportes)."</p>";

        echo "<p>Elemento siguiente en el que esta situado el puntero: ".next($deportes)."</p>";

        echo "<p>Elemento ultimo en el que esta situado el puntero: ".end($deportes)."</p>";

        echo "<p>Elemento previo en el que esta situado el puntero: ".prev($deportes)."</p>";




    ?>
    
</body>
</html>