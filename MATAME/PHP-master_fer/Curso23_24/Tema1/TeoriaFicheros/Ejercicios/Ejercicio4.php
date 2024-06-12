<?php
    if(isset($_POST["Contar"])){

        $error_formu = $_FILES["fichero"]["name"] == "" || $_FILES["fichero"]["error"] || $_FILES["fichero"]["type"] != "text/plain" || $_FILES["fichero"]["size"]> 2500*1024 ;
    }

?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subir archivos al servidor</title>
    <style>.error {color: red};</style>
</head>

<body>

    <h1>Teoria subir ficheros al servidor</h1>
    <form action="Ejercicio4.php" method="post" enctype="multipart/form-data">
        <p>
            <label for="fichero">Selecciona un fichero de texto para contar sus palabras (Max 2.5MB):</label>
            <input type="file" name="fichero" id="fichero" accept=".txt">
            <?php
                if(isset($_POST["Contar"]) && $error_formu) {

                    if($_FILES["fichero"]["name"] ==""){

                        echo "<span class='error'>*</span>";

                    }elseif($_FILES["fichero"]["error"]){

                        echo "<span class='error'>Error: no se ha podido subir el fichero al servidor</span>";

                    }elseif($_FILES["fichero"]["type"] !="text/plain"){

                        echo "<span class='error'>Error: no has seleccionado un fichero .txt</span>";

                    }else{

                        echo "<span class='error'>Error: el tamaño del fichero supera los 2.5MB</span>";
                    }
                }

            ?>

        </p>


        <p>
            <button type="submit" name="Contar">Contar</button>
        </p>
    </form>
    <?php

        if(isset($_POST["Contar"]) && !$error_formu) {

            $contenido_fichero=file_get_contents($_FILES["fichero"]["tmp_name"]);

            echo "<h3>El numero de palabras que contiene el archivo selecciona es de: ".str_word_count($contenido_fichero)."</h3>";
        }

    ?>
</body>

</html>