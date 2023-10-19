<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <p>
    Teclee una palabra en un campo de texto 

        no se han repetido caracter

        se han repetido caracter
    </p>
    <form action="ejerPalabra.php" method = "post">
    <p>
        <label for="palabra">Introduce una palabra:</label>
        <input type="text" name="palabra" id="palabra"/>
        <?php          

            if(isset($_POST("palabra")) && !$errorForm){

                for($i = 1; $i < $texto; $i++){
                    for($a = 0; $a < $i; $a++){
                        if($a == $i){
                            break;
                        }
                    }
                    if($j < $i){
                        
                    }                    
                }
                if($i == $texto){
                    $respuesta = "No se repite ningún caracter";
                }else{
                    $respuesta = "Carácteres repetidos";
                }

            }





            if(isset($_POST["palabra"])){

                $palabra = $_POST["palabra"];

                for($i = 0; $i < strlen($palabra); $i++){
                    for($a = 0; $a < $i; $a++){
                        if($a == $i){
                            echo "<p>caracteres repetidos</p>";
                        }else{
                            echo "<p>No hay caracteres repetidos</p>";
                        }
                    }
                    
                }
            }
        ?>

        <button type="submit" name="palabra">Buscar</button>

    </p>

    </form>
    
</body>
</html>