<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Ejercicio 1 POO</title>
    </head>
    <body>
        <h1>Ejercicio 4 POO</h1>
        <?php
            require "class_empleado.php";

            $empl1 = new Empleado("Juan Palomo", "2500");
            $empl2 = new Empleado("María Aguilar", "3500");

            echo "<h2>Información de mis empleados creados</h2>";

            $empl1->impuestos();
            $empl2->impuestos();         

        ?>

    </body>
</html>