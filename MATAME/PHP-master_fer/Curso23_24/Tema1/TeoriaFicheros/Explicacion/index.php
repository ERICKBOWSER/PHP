<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teoria Ficheros</title>
</head>
<body>
    <?php
        //SIEMPRE ASIGNAR A UNA VARIABLE
        @$fd1=fopen("prueba.txt","r+"); //MODO DE APERTURA (Segundo espacio) R: LECTURA , W: ESCRITURA , a: ESCRIBIR AL FINAL DEL FICHERO //SI LE METO UN + LE DA UN VALOR AÑADIDO ES DECIR PASA A SER EL SIGUIENTE TB
        //SI LA CARPETA TIENES PERMISOS Y LE PONEMOS UNA W Y NO EXISTE EL FICHERO TE LO CREA 

        //ESTO ES POR SI ACASO NO PUEDO ABRIR EL FICHERO
        if(!$fd1){
            die("<p>No se ha podido abrir el fichero prueba.txt</p>"); //ESTO ES IGUAL QUE UN exit o un break;
        }else{
            echo "<h1>Fichero en orden</h1>";
        }

        //PARA COGER 1 LINEA
        $linea=fgets($fd1);
        echo "<p>".$linea."</p>";
       //SI LO ESCRIBO OTRA VEZ SE PASA A LA SEGUNDA LINEA Y ASI SUCESIVAMENTE

       $linea=fgets($fd1);
       echo "<p>".$linea."</p>";

       $linea=fgets($fd1);
        echo "<p>".$linea."</p>";

        $linea=fgets($fd1);
        echo "<p>".$linea."</p>";


        fseek($fd1,0); //ESTO ES PARA IR AL PRINCIPIO DEL FICHERO
        echo "<p><strong>CON WHILE: </strong></p>";

        while ($linea=fgets($fd1)) {
            echo "<p>".$linea."</p>";
        }

        //fputs() son lo mismo          //PHP_EOL LE METO UN FIN A LA ULTIMA LINEA ES DECIR LO ULTIMO QUE TENGO "aqui" y se pone al lado sin espacio ni intro 
        fwrite($fd1,PHP_EOL."No me vas a dejar escribir"); //PARA ESCRIBIR EN UN FICHERO
         
        fclose($fd1); //SIEMPRE AL FINAL CERRAR EL FICHERO


        $todo_fichero=file_get_contents("prueba.txt"); //COGER EL CONTENIDO DEL FICHERO Y TRANSFORMARTELO EN STRING
        echo "<pre>".$todo_fichero."</pre>"; //LO IMPRIMO //EL PRE ES PARA LOS SALTOS DE LINEA
        echo nl2br($todo_fichero); //LO MISMO QUE EL PRE

        $todo_fichero=file_get_contents("https://www.google.com");
        echo $todo_fichero;
    ?>
</body>
</html>