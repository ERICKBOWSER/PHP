<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teoría ficheros de texto</title>
</head>
<body>
    <?php
        // SIEMPRE HAY QUE ALMACENARLO 
        // Devuelve una especie de puntero del fichero
        @$fd1 = fopen("prueba.txt", "r+"); // Se que puede fallar

        /* IMPORTANTE
            w y a crea uno si no existe        
        */

        if(!$fd1){
            die("<p> No se ha podido abrir el fichero"); // MUEREEEEEEEEEEEEE
        }

        // Si no hay fallos 
        echo "<h1> Por ahora todo en orden</h1>";

        $linea = fgets($fd1); // coge una linea 

        echo "<p>" . $linea . "</p>";


        // si se repite coge la siguiente

        $linea = fgets($fd1); // coge una linea 

        echo "<p>" . $linea . "</p>";
        $linea = fgets($fd1); // coge una linea 

        echo "<p>" . $linea . "</p>";
        $linea = fgets($fd1); // coge una linea 

        echo "<p>" . $linea . "</p>";
        $linea = fgets($fd1); // coge una linea 

        echo "<p>" . $linea . "</p>";
        $linea = fgets($fd1); // coge una linea 

        echo "<p>" . $linea . "</p>";

        // CUANDO LLEGA A LA ÚLTIMA SE QUEDA ALLÍ Y CREA LINEAS VACIAS

        
        fseek($fd1, 0); // Va a la primera linea 

        echo "<p>Bucle</p>";

        while ($linea = fgets($fd1)) { // mientras la asignación tenga exito se ejecuta
            # code...
            echo "<p>" . $linea . " -_- </p>";
        }

        // ESCRIBIR

        // PHP_EOL que es de End Of Lane
        fwrite($fd1, PHP_EOL . "prueba de que se escribe");

        // Coge todas las lineas del fichero
        $todoFichero = file_get_contents("prueba.txt"); // También sirve para URL
        echo "Todo el contenido<br/>";
        echo nl2br($todoFichero); //    Añade br a los saltos de linea












        // Cerrar fichero (SIEMPRE SE TIENE QUE HACER)
        fclose($fd1);


    ?>  
    
    




































</body>
</html>