<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teoria Fechas</title>
</head>
<body>

    <h1>Teoria de Fechas</h1>

    <?php

        echo "<p>".time()."</p>"; //Tiempo con peazo numero

        echo "<p>".date("d/m/y")."</p>"; //DIA/MES/AÑO

        echo "<p>".date("d/m/Y")."</p>"; //DIA/MES/AÑO PERO EL AÑO SALE EN 4 DIGITOS

        echo "<p>".date("h:i:s")."</p>"; //HORA/MINUTO/SEGUNDO

        echo "<p>".date("d/m/Y h:i:s")."</p>";

        if(checkdate(2,28,2023)){ //DEVUELVE TRUE O FALSE POR checkdate(2,29,2023) esta devolveria false es decir fecha mala porque el 29 de febrero ese año no estaba

            echo "<p>Fecha Buena</p>";
        }else{
            echo "<p>Fecha Mala</p>";
        }

        //echo mktime(hora,minuto,segundo,mes,dia,año);

        echo date("d/m/Y",mktime(0,0,0,9,28,2002)); //Me da el tiempo que ha pasado desde esa fecha en segundos pero le tengo que pasar numeros

        echo "<p>".strtotime("09/23/1976")."</p>"; //Lo mismo que el mktime pero pasandole un string en ver de numeros


        //FUNCION MATEMATICAS PARA LAS SIGUIENTES PRACTICAS

        echo "<p>".floor(6.5)."</p>"; //Redondea hacia abajo floor = suelo 
        echo "<p>".ceil(6.5)."</p>"; //Redondea hacia arriba ceil = techo

        echo "<p>".abs(-8)."</p>"; //Me da el valor en absoluto

        printf("<p>%.2f</p>",5.6666*7.8888); //LE DOY FORMATO AL NUMERO PARA QUE SALGA CON 2 DECIMALES

        $resultado=sprintf("%.2f",5.6666*7.8888); //SE LE ASIGNA EL TOTAL A LA VARIABLE

        echo $resultado;

        for ($i=0; $i <= 20; $i++) { 

            echo "<p>".sprintf("%03d",$i)."</p>"; //Pone 3 digitos y los que no lleguen a 3 digitos les pone un 0 delante

        }


    ?>
    
    
    
</body>
</html>