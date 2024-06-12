

<?php



    if(isset($_POST["codificar"])){

        $error_desplaza = $_POST["desplazamiento"] == "" || !is_numeric($_POST["desplazamiento"]) || $_POST["desplazamiento"] < 1 || $_POST["desplazamiento"] > 26;

        $error_texto = $_POST["texto"] == "" || is_numeric($_POST["texto"]);

        @$error_fichero = $_FILES["fichero"]["name"] == "" || $_FILES["fichero"]["error"] || $_FILES["fichero"]["type"] != "text/plain" ||$_FILES["fichero"]["size"] > 1250 * 1024;

        $error_formu = $error_desplaza || $error_texto || $error_fichero;

      


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
    
    <form action="ejercicio3.php" method="post" enctype="multipart/form-data">

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
            @$fd=fopen($_FILES["archivo"]["tmp_name"],"r");
            if(!$fd){
                die("<p>No se ha podido abrir el fichero de claves seleccionada</p>");
            }
            $primera_linea=fgets($fd);
            while($linea=fgets($fd)){
                $datos_linea=mi_explode(";",$linea);
                $claves[$datos_linea[0]]=$datos_linea;
            }
            fclose($fd);
            $texto=$_POST["texto"];
            $desplazamiento=$_POST["desplazamiento"];
            $respuesta="";

            for ($i=0; $i <strlen($texto); $i++) { 
               if($texto[$i]>="A" && $texto[$i]<="Z"){

                $respuesta.=$claves[$texto[$i]][$desplazamiento];

               }else{
                $respuesta.=$texto[$i];
               }
            }
            echo $respuesta;

        }
       

    
    ?>


</body>
</html>