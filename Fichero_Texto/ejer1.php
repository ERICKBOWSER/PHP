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
    <style>
        .error{color: red}
    </style>
</head>
<body>
    <h1>Ejercicio 1</h1>
    <form action="ejer1.php" method="post">
        <p>
            <label for="num"> Introduzca un número entre 1 y 10 (ambos inclusive):</label>
            <input type="text" name="num" id="num" value="<?php if(isset($_POST["num"])) echo $_POST["num"];?>"/>
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
        if(isset($_POST["btnEnviar"])&&  !$errorForm){

            $nombreFichero = "tabla_" . $_POST["num"]. ".txt";
            if(!file_exists("Tablas/" . $nombreFichero)){ // SI EL FICHERO NO EXISTE LO GENERA

                @$fd = fopen("Tablas/" . $nombreFichero, "w");

                if(!$fd){
                    die("<p>No se ha podido crear el fichero 'Tablas/" . $nombreFichero . "'</p>");
                }
                for($i = 1; $i <= 10; $i++){
                    fputs($fd, $i . " x " . $_POST["num"] . " = " . $i * $_POST["num"] . PHP_EOL);
                }

                fclose($fd);
            }            

            echo "<p>Fichero Generado con éxito</p>";
        }

    ?>

</body>
</html>