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
            require "class_uva.php";
            $uva = new Uva("verde", "pequeña", true);

            echo "<h2>Información de mi uva creada</h2>";
            if($uva -> tieneSemilla()){
                echo "<p>La uva creada es de color " . $uva -> getColor() . ", tamaño " . $uva -> getTamanio() . " y tiene semilla";
            }else{
                echo "<p>La uva creada es de color " . $uva -> getColor() . ", tamaño " . $uva -> getTamanio() . " y no tiene semilla";
            }

        ?>

    </body>
</html>