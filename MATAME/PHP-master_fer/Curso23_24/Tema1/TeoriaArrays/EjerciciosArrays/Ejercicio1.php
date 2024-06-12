<?php

    function generar_pares($numeros){

        for ($i=0; $i < 2 * $numeros; $i+=2) { 
            
            $pares[]=$i;

        }

        return $pares;

    }

    define('NPARES',10)


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio1</title>
</head>
<body>
    <h1>Ejercicio1</h1>
    <?php

        $pares=generar_pares(NPARES);
        echo "<p>";
        for ($i=0; $i < count($pares); $i++) { 
            echo $pares[$i]."<br/>";    
        }

        echo "</p>";

    ?>
</body>
</html>