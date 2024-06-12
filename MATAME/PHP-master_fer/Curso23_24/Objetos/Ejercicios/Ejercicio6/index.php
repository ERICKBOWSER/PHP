<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio7 POO</title>
</head>
<body>
    <h1>Ejercicio6 POO</h1>
    <?php
        require "class_menu.php";

        $m=new Menu();
        $m->cargar("http://wwww.marca.com","Marca");
        $m->cargar("http://wwww.nintendo.com","Nintendo");
        $m->cargar("http://wwww.msn.com","MSN");
        $m->vertical();
        $m->horizontal();

    ?>
</body>
</html>