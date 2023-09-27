<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        $ciudad = array("Madrid", "Barcelona", "Londres", "New York", "Los Ángeles", "Chicago");

        for ($i=0; $i < count($ciudad); $i++) { 
            # code...
            echo "<p>La ciudad con el indice " . $i . " tiene el nombre " . $ciudad[$i] . "</p>";
        }
    ?>
</body>
</html>