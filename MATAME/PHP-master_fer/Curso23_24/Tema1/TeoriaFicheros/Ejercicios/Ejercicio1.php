
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
    <title>Ejercicio1</title>
    <style>.error{color:red};</style>
</head>
<body>
    <h1>Ejercicio1</h1>
    <form action="Ejercicio1.php" method="post">

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
        <button type="submit" name="btnEnviar">Crear Fichero</button>
    </p>

    </form>

    <?php

        if(isset($_POST["btnEnviar"]) && !$error_form){

            $nombre_fichero="tabla_".$_POST["num"].".txt";
           
            if(!file_exists("Tablas/".$nombre_fichero,"w")){
                
                @$fd=fopen("Tablas/".$nombre_fichero,"w");
                if(!$fd){
                    die("<p>No se ha podido crear el fichero 'Tablas/".$nombre_fichero."'</p>");
                }
                for ($i=1; $i <= 10 ; $i++) { 
                    fputs($fd,$i." x ".$_POST["num"]." = ".($i*$_POST["num"]).PHP_EOL);
                }
    
                fclose($fd);
            }
            echo "<p>Fichero generado con exito</p>";   
        }

    ?>

</body>
</html>