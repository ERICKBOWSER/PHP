<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio3 POO</title>
</head>
<body>
    <h1>Ejercicio3 POO</h1>
    <?php
        require "class_fruta.php";
        echo "<h2>Informacion de mis frutas</h2>";
        echo "<p>Frutas creadas hasta el momento: ".Fruta::cuantaFruta()."</p>";
        $pera=new Fruta("verde","mediano");

        echo "<p>Creando la pera..</p>";
        $pera=new Fruta("verde","mediano");
        echo "<p>Frutas creadas hasta el momento: ".Fruta::cuantaFruta()."</p>";

        echo "<p>Creando un melon..</p>";
        $melon=new Fruta("amarillo","grande");
        echo "<p>Frutas creadas hasta el momento: ".Fruta::cuantaFruta()."</p>";

        echo "<p>Destrunyendo el melon..</p>";
        unset($melon);
        //$melon=null;     tambien se detruye asi
        echo "<p>Frutas creadas hasta el momento: ".Fruta::cuantaFruta()."</p>";

    ?>
</body>
</html>