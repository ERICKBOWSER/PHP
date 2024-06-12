<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teoria de String</title>
</head>
<body>
    <?php


        $string1="Hola que tal?";
        $string2="Juan";

        echo "<h1>".$string1." ".$string2."</h1>";

        $longitud=strlen($string1); //Longitud de un string (Tambien cuenta los espacios)
        echo "<p>La longitud del String: '".$string1."' es: ".$longitud."</p>";


        $a=$string1[3]; //Accede a la posicion del string es decir como string es "Hola" accederia a las 3 que es la letra "a"

        echo "<p>".$a."</p>";

        $string1[12]="!"; //Cambio la letra de la posicion 12 que seria "?" por una "!"

        echo "<p>".$string1."</p>";

        echo "<p>".strtoupper($string1)."</p>"; //Lo escribe en mayuscula !NO LO CONVIERTE!
        echo "<p>".strtolower($string1)."</p>"; //Lo escribe en minuscula !NO LO CONVIERTE!

        $nuevo_s1=trim($string1); //LE QUITA LOS ESPACIOS


        $prueba="Hola mi nombre es: Fernando";
        $sep_arr=explode(" ",$prueba); //CONVIERTE EN UN ARRAY EL STRING  //EL PRIMER VALOR ES EL DELIMITADOR DE SEPARACION , EL SEGUNDO ES EL STRING

        print_r($sep_arr);


        $prueba2="archivo.txt";
        $sep_arr2=explode(".",$prueba2); //PARA PILLAR LA EXTENSION DE UN ARCHIVO 

        echo "<p>Extension leida: ".end($sep_arr2)."</p>"; //PILLA EL ULTIMO DEL ARRAY CON EL END



        $arr=array("hola","Juan","Antonio",12,"Maria");

        print_r($arr);
        $string3=implode(":",$arr); //FUNCIONA AL REVES QUE EL EXPLODE , ESTE TE CONVIERTE EL ARRAY EN UN STRING y te saldria "hola:Juan:Antonio:12:Maria"
        echo "<p>".$string3."</p>";


        echo "<p>".substr("hola que tal, Juan",14,4)."</p>"; //EN LA PRIMERA SE PONE EN LA CADENA , DESPUES EN QUE POSICION SE VA A PONER Y DESPUES A PARTIR DE AHI LOS CARACTERES QUE TE VA A DAR
        echo "<p>".substr("hola que tal, Juan",6)."</p>"; //SI LE DOY SOLO UN PARAMETRO NUMERICO TE COGE DESDE ESA POSICION HASTA EL FINAL 
        echo "<p>".substr("hola que tal, Juan",-4)."</p>"; //SI LE DAS UN VALOR NEGATIVO EMPIEZA DESDE LA DERECHA HASTA LA IZQ 
        echo "<p>".substr("hola que tal, Juan",strlen("hola que tal, Juan"),-4)."</p>"; //EL STRLEN ES PARA LA LONGITUD MAS O MENOS LO MISMO QUE EL DE ARRIBA

    ?>
    
</body>
</html>