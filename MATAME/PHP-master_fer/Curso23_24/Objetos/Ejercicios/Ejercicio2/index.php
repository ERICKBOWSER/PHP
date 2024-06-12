<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio2 POO</title>
</head>
<body>
    <h1>Ejercicio2 POO</h1>
    <?php
        require "class_fruta.php";
        echo "<h2>Informacion de mi fruta pera</h2>";
        $pera=new Fruta("verde","mediano");
    ?>
</body>
</html>