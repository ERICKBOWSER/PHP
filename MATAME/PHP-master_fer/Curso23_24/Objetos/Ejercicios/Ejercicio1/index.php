<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio1 POO</title>
</head>
<body>
    <h1>Ejercicio1 POO</h1>
    <?php
        require "class_fruta.php";
        $pera=new Fruta();
        $pera->set_color("verde");
        $pera->set_tamanyo("mediana");

        echo "<h2>Informacion de mi fruta pera</h2>";
        echo "<p><strong>color: </strong>".$pera->get_color()."</p>";
        echo "<p><strong>tamaño: </strong>".$pera->get_tamanyo()."</p>";
    ?>
</body>
</html>