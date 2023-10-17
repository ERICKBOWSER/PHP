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
    <h1>Ejercicio 2</h1>
    <form action="ejer2.php" method="post">
        <p> 
            <label for="num">Introduce un número:</label>
            <input type="text" name="num" id="num">
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
            <button type="submit" name="btnEnviar">Crear fichero</button>
        </p>
    </form>    
    <?php
        if(isset($_POST["btnEnviar"]) && !$errorForm){
            // Obtenemos el nombre del fichero
            $nombreFichero = "tabla_" . $_POST["num"] . ".txt";
            @$fd = fopen("Tablas/" . $nombreFichero, "r");

            if(!file_exists("Tablas/" . $nombreFichero)){
                // Si no existe
                if(!$fd){
                    die("<p> El fichero 'Tablas/" . $nombreFichero . "' no existe</p>");
                }              
            }else{
                while($linea = fgets($fd)){
                    echo "<p>" . $linea . "</p>";
                }
            }
        }
    ?>
</body>
</html>














