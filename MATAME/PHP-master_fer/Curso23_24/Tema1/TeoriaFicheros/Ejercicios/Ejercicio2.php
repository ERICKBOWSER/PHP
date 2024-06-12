<?php

if(isset($_POST["btnEnviar"])){

    $error_form=$_POST["num"]=="" || !is_numeric($_POST["num"]) || $_POST["num"]<1 || $_POST["num"]>10;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio2</title>
    <style>.error{color:red};</style>
</head>
<body>
    <h1>Ejercicio2</h1>
    <form action="Ejercicio2.php" method="post">

    <p>

        <label for="num">Introduce un numero entre 1 y 10 (ambos inclusive):</label>
        <input type="text" name="num" id="num" value="<?php if(isset($_POST["num"])) echo $_POST["num"];?>">
        <?php
            if(isset($_POST["btnEnviar"]) && $error_form){
                if($_POST["num"]==""){
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

        if (file_exists($ruta_fichero)) {

            $fichero_leido = file_get_contents($ruta_fichero);
            echo nl2br($fichero_leido);

        } else {
            echo "<p>Fichero no encontrado</p>";
        }
    }
    ?>

</body>
</html>
