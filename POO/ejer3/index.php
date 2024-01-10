<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Ejercicio 1 POO</title>
    </head>
    <body>
        <h1>Ejercicio 3 POO</h1>
        <?php
            require "class_fruta.php";

            echo "<h2>Información de mis frutas </h2>";
            echo "<p>Frutas creadas hasta el momento: " . Fruta::cuantaFruta() . "</p>";
            $pera = new Fruta("verde", "mediano");
            echo "<p>Creando una pera...</p>";

            echo "<p>Frutas creadas hasta el momento: " . Fruta::cuantaFruta() . "</p>";
            $melon = new Fruta("amarillo", "grande");
            echo "<p>Creando un melón...</p>";

            echo "<p>Frutas creadas hasta el momento: " . Fruta::cuantaFruta() . "</p>";
            unset($melon);
            echo "<p>Destruyendo el melón...</p>";
        ?>

    </body>
</html>