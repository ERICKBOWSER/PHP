<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio8</title>
</head>
<body>
    <?php

        function generarNumeros($num){

            for ($i=0; $i < $num; $i++) { 
                
                $numeros[]=$i+1;

            }

            return $numeros;

        }

        $arr=generarNumeros(10);

        $suma = 0;
        $contador = 0;

        foreach ($arr as $indice => $valor) {


            if ($valor % 2 == 1) {

                echo "<p>".$valor."</p>";

            }else{

                $suma += $valor;
                $contador++;
            }
            
        }

        $media = $suma/$contador;
        echo "<p>La media de los pares es: ".$media."</p>";



    ?>
    
</body>
</html>