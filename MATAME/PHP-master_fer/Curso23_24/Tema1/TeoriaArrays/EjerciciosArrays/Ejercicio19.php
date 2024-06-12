<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio19</title>
</head>
<body>
    <?php

        $matriz['Madrid']['Pedro']['Edad']='32';
        $matriz['Madrid']['Pedro']['Tlf']='123456789';
        $matriz['Madrid']['Pepe']['Edad']='44';
        $matriz['Madrid']['Pepe']['Tlf']='123456789';
        $matriz['Barcelona']['Luis']['Edad']='22';
        $matriz['Barcelona']['Luis']['Tlf']='123456789';
        $matriz['Barcelona']['Antonio']['Edad']='42';
        $matriz['Barcelona']['Antonio']['Tlf']='123456789';
        $matriz['Toledo']['Jose']['Edad']='26';
        $matriz['Toledo']['Jose']['Tlf']='123456789';
        $matriz['Toledo']['Leo']['Edad']='25';
        $matriz['Toledo']['Leo']['Tlf']='123456789';


        foreach ($matriz as $ciudad => $personas) {
            echo "<p>Amigos en : ".$ciudad."</p>";
            echo "<ol>";
            foreach ($personas as $nombre => $datos) {
                echo "<li>Nombre: ".$nombre." Edad: ".$datos['Edad']." Telefono: ".$datos['Tlf']."</li>";
            }
            echo "</ol>";
        }
    ?>
    
</body>
</html>