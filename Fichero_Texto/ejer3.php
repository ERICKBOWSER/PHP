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
    <h1>Ejercicio 3</h1>
    <p>
    Realizar una web con un formulario que pida dos números n y m entre 1 y 10,
lea el fichero tabla_n.txt con la tabla de multiplicar de ese número de la
carpeta Tablas, y muestre por pantalla la línea m del fichero. Si el fichero no
existe debe mostrar un mensaje informando de ello.
</p>
    <form action="ejer3.php" method="post">
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
            <label for="num2">Introduce un número:</label>
            <input type="text" name="num2" id="num2">
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