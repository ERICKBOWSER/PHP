<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Ejercicio 6 POO</title>
    </head>
    <body>
        <h1>Ejercicio 6 POO</h1>
        <?php
            require "class_menu.php";

            $n = new Menu();
            $n -> cargar("http://www.marca.com", "Marca");
            $n -> cargar("http://www.nintendo.com", "Nintendo");
            $n -> cargar("http://www.msn.com", "MSN");

            $n->vertical();
            $n->horizontal();
  

        ?>

    </body>
</html>