<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php

        $array["Madrid"]["Pedro"]["Edad"] = "32";
        $array["Madrid"]["Pedro"]["Tlf"] = "91234124";
        $array["Madrid"]["Antonio"]["Edad"] = "34";
        $array["Madrid"]["Antonio"]["Tlf"] = "5239420422";
        $array["Madrid"]["Alguien"]["Edad"] = "23";
        $array["Madrid"]["Alguien"]["Tlf"] = "69020342";

        $array["Barcelona"]["Susana"]["Edad"] = "25";
        $array["Barcelona"]["Susana"]["Tlf"] = "623342324";
        $array["Toledo"]["Nombre"]["Edad"] = "45";
        $array["Toledo"]["Nombre"]["Tlf"] = "23423902";
        $array["Toledo"]["Nombre2"]["Edad"] = "56";
        $array["Toledo"]["Nombre2"]["Tlf"] = "45604345";

        foreach ($array as $ciudad => $personas) {
            # code...
            echo "<p>Amigos en: " . $ciudad . ":</p>";
            echo "<ol>";
            foreach($personas as $nombre => $datos){
                echo "<li>Nombre: " . $nombre . ". Edad:" . $datos["Edad"] . ". Teléfono: " . $datos["Tlf"] . "</li>";
            }
            echo "</ol>";
        }


    ?>    
</body>
</html>