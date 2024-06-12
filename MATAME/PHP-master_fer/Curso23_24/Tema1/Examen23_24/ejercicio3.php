

<?php



    if(isset($_POST["codificar"])){

        $error_desplaza = $_POST["desplazamiento"] == "" || !is_numeric($_POST["desplazamiento"]) || $_POST["desplazamiento"] < 1 || $_POST["desplazamiento"] > 26;

        $error_texto = $_POST["texto"] == "" || is_numeric($_POST["texto"]);

        @$error_fichero = $_FILES["fichero"]["tmp_name"] == "" || $_FILES["fichero"]["error"] || $_FILES["fichero"]["error"] || $_FILES["fichero"]["type"] != "text/plain" ||$_FILES["fichero"]["size"] > 1250 * 1024;

        $error_formu = $error_desplaza || $error_texto || $error_fichero;

      


    }

    
    function codificarCesar($texto, $desplazamiento) {

        
        @$fd=fopen("claves_cesar.txt","r");

        $resultado = "";
        $longitud = strlen($texto);
        for ($i = 0; $i < $longitud; $i++) {
            $caracter = explode(";",$texto[$i]);



            if (($caracter)) {




            } else {
                $resultado .= $caracter;
            }
        }
        fclose($fd);
        return $resultado;

    }
   




?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>.error{color:red}</style>
</head>
<body>
    
    <form for="ejercicio2.php" method="post" enctype="multipart/form-data">

        <h1>Ejercicio 3. Codifica una frase</h1>

        <p>
            
        <label>Introduza un texto</label><input name='texto' id='texto' value='<?php if(isset($_POST["texto"])) echo $_POST["texto"];?>'>

            <?php

            if(isset($_POST["desplazamiento"]) && $error_texto){
                echo "<span class='error'>*Introduce una cadena de texto por favor*</span>";
            }

            ?>

        </p>

        <p>
            
            <label>Desplazamiento</label><input name='desplazamiento' id='desplazamiento' value='<?php if(isset($_POST["texto"])) echo $_POST["desplazamiento"];?>'>
        
        

            <?php

                if(isset($_POST["desplazamiento"]) && $error_desplaza){
                    echo "<span class='error'>*Introduce un numero por favor*</span>";
                }

            ?>
        
        </p>

        <p>
            
        
            <label>Selecciona el archivo de claves (.txt y menor 1'25MB)</label>
            <input  type="file" name="fichero" id="fichero" accept="text/plain">
    
            <?php



                if(isset($_POST["codificar"]) && $error_fichero){

                    if($_FILES["fichero"]["tmp_name"] == ""){
                    
                        echo "<span class='error'>*</span>";

                    }elseif($_FILES["fichero"]["size"] > 1250*1024){

                        echo "<span class='error'>El tamaño del archivo es mayor que 1'25MB</span>";

                    }elseif($_FILES["fichero"]["type"] != "text/plain"){

                        echo "<span class='error'>Introduce un formato de archivo valido por favor</span>";

                    }else{

                        echo "<span class='error' >Error en el fichero no se ha podido subir al servidor</span>";

                    }


                  
                }


            ?>
    
    
        </p>


        <p><label></label><button name="codificar">Codificar</button></p>

    </form>



    <?php


        if(isset($_POST["codificar"]) && !$error_formu){


            echo "<h1>Respuesta</h1>";
            echo "<p>El texto introducido codificado seria:</p>";
            echo codificarCesar($_POST["texto"],$_POST["desplazamiento"]);

        }
       

    
    ?>


</body>
</html>