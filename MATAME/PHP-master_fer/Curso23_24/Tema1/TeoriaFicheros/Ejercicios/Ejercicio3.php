<?php

if(isset($_POST["btnEnviar"])){

    
    $error_num=$_POST["num"]=="" || !is_numeric($_POST["num"]) || $_POST["num"]<1 || $_POST["num"]>10;
    $error_num2=$_POST["num2"]=="" || !is_numeric($_POST["num2"]) || $_POST["num2"]<1 || $_POST["num2"]>10;

    $error_form=$error_num || $error_num2;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio3</title>
    <style>.error{color:red};</style>
</head>
<body>
    <h1>Ejercicio3</h1>
    <form action="Ejercicio3.php" method="post">

        <p>

            <label for="num">Introduce un numero entre 1 y 10 (ambos inclusive):</label>
            <input type="text" name="num" id="num" value="<?php if(isset($_POST["num"])) echo $_POST["num"];?>">
            <?php
                if(isset($_POST["btnEnviar"]) && $error_num){
                    if($_POST["num"]==""){
                        echo "<span class='error'>Campo vacio</span>";
                    }else{
                        echo "<span class='error'>Error no has introducido un numero</span>";
                    }
                }
            ?>
        </p>

        <p>

            <label for="num2">Introduce un numero de linea entre 1 y 10 (ambos inclusive):</label>
            <input type="text" name="num2" id="num2" value="<?php if(isset($_POST["num2"])) echo $_POST["num2"];?>">
            <?php
                if(isset($_POST["btnEnviar"]) && $error_num2){
                    if($_POST["num2"]==""){
                        echo "<span class='error'>Campo vacio</span>";
                    }else{
                        echo "<span class='error'>Error no has introducido un numero</span>";
                    }
                }
            ?>
        </p>

        <p>
            <button type="submit" name="btnEnviar">Buscar Fichero</button>
        </p>
    </form>

    <?php
    if (isset($_POST["btnEnviar"]) && !$error_form) {
        $nombre_fichero = "tabla_".$_POST["num"].".txt";
        $ruta_fichero = "Tablas/".$nombre_fichero;
        $numeroLinea = $_POST["num2"];

        if (file_exists($ruta_fichero)) {

            @$fd1=fopen($ruta_fichero,"r");
            for ($i=0; $i < $numeroLinea; $i++) { 
                $linea=fgets($fd1);
            }
            echo "<p>".$linea."</p>";

        } else {
            echo "<p>Fichero no encontrado</p>";
        }
        fclose($fd1);
    }
    ?>

</body>
</html>
