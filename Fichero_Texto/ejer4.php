<?php
    if(isset($_POST["btnEnviar"])){
        $errorForm = $_POST["num"] == "" || !is_numeric($_POST["num"])
            || $_POST["num"] < 1 || $_POST["num"] > 10;
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Ejercicio 4</h1>
    <p>
    Realizar una web con un formulario que seleccione un fichero de texto y mues-
tre por pantalla el número de palabras que contiene. Como ejemplo usar el
archivo adjunto (pag2000.txt). Controlar que el fichero seleccionado por el
usuario sea de tipo texto ( .txt) y que el tamaño máximo del archivo sea 2’5MB.
    </p>
    <form action="ejer3.php" method="post" enctype="multipart/form-data">
        <p> 
            <label for="archivo">Selecciona un fichero:</label>
            <input type="file" name="archivo" id="archivo">
            <?php
                if(isset($_POST["btnEnviar"]) && $errorForm){
                    if($_POST["num"] == ""){
                        echo "<span class='error'>Campo vacio</span>";
                    }else{
                        echo "<span class='error'>No has introducido un número</span>";                    
                    }
                }
            ?>
        </p>
        <p>
            <button type="submit" name="btnEnviar">Enviar</button>
        </p>
    </form>    
    <?php

    // str_word_count
        if(isset($_POST["btnEnviar"]) && !$errorForm){
            // Obtenemos el nombre del fichero
            $nombreFichero = "tabla_" . $_POST["num"] . ".txt";
            @$fd = fopen("Tablas/" . $nombreFichero, "r");

                // Si no existe
                if(!$fd){
                    die("<p> El fichero 'Tablas/" . $nombreFichero . "' no existe</p>");
                }              

            $contador = 1;
            while($contador <= $_POST["num2"]){
                $linea = fgets($fd);
                $contador++;
            }
            echo "<p>" . $linea . "</p>";

            fclose($fd);
        }
    ?>
</body>
</html>