<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio3</title>
</head>
<body>

    <?php

        $peliculas['enero']=9;
        $peliculas['febrero']=12;
        $peliculas['marzo']=0;
        $peliculas['abril']=17;


        foreach ($peliculas as $meses => $valor) {
            
            if ($valor == 0) {

                echo "<p>Mes : <b>".$meses."</b> No se han visto peliculas en este mes</p>";
                
            }else {

                echo "<p>Mes : <b>".$meses."</b> numero de peliculas: <b>".$valor."</b></p>";

            }
        }

    ?>
    
</body>
</html>