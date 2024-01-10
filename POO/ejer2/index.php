<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Ejercicio 1 POO</title>
    </head>
    <body>
        <h1>Ejercicio 2 POO</h1>
        <?php
            require "class_fruta.php";

            echo "<h2>Información de mi fruta pera </h2>";
            $pera = new Fruta("verde", "mediano");
        ?>

    </body>
</html>