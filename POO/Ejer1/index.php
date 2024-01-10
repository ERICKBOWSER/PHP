<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Ejercicio 1 POO</title>
    </head>
    <body>
        <h1>Ejercicio 1 POO</h1>
        <?php
            require "class_fruta.php";

            $pera = new Fruta();
            $pera -> setColor("verde");
            $pera -> setTamanio("mediano");

            echo "<h2>Información de mi fruta pera </h2>";

            echo "<p><strong>Color: </strong>" . $pera -> getColor() . "<br><strong>Tamaño: </strong>" . $pera->getTamanio();




        ?>


    </body>
</html>