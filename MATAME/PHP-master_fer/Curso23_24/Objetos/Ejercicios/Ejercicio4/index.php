<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio4 POO</title>
</head>
<body>
    <h1>Ejercicio4 POO</h1>
    <?php
        require "class_uva.php";

        $uva=new Uva("verde","pequeña",false);

        echo "<h2>Informacion de mi uva creada</h2>";
        if($uva->tieneSemilla()){

            echo "<p>La uva creada es de color: ".$uva->get_color().", tamaño: ".$uva->get_tamanyo()." y tiene semilla</p>";

        }else{
            echo "<p>La uva creada es de color: ".$uva->get_color().", tamaño: ".$uva->get_tamanyo()." y no tiene semilla</p>";
        }

    ?>
</body>
</html>