<?php

    function mi_strlen($texto){

        $cont=0;
        while (isset($texto[$cont])) {
            $cont++;
        }

        return $cont;
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
    <h1>Ejercicio1</h1>
    <form action="Examen.php" method="post">
    
    <p>
        <label>Introduza un texto </label>
        <input type="text" name="texto" id="texto" value="<?php if(isset($_POST["texto"])) echo $_POST["texto"];?>">
    </p>

    <p>
        <button type="submit" name="contar">Contar</button>
    </p>

    <?php
        if(isset($_POST["contar"])){
            echo "<h2>Respuesta</h2>";
            echo "<p>El numero de caracteres tecleado ha sido de: ".mi_strlen($_POST["texto"])."</p>";
        }

    ?>



    </form>
    
</body>
</html>