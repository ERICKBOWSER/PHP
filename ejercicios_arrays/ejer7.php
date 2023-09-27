<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        $ciudad = array("MD" => "Madrid","BARC" => "Barcelona","LD" => "Londres","NY" => "New York","LA" => "Los Ángeles","CH" => "Chicago");

        foreach ($ciudad as $dato => $contenido) {
            # code...
            echo "<p>La abreviatura " . $dato . " pertenece a " . $contenido . "</p>";
        }
    ?>
</body>
</html>