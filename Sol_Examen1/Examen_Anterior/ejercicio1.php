<?php
    function mi_strlen($texto)
    {
        $cont=0;
        while(isset($texto[$cont])){
            var_dump($texto[$cont]);
            $cont++;            
        }
        return $cont;
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio1 Exam Anterior</title>
</head>
<body>
    <h1>Ejercicio 1</h1>
    <form action="ejercicio1.php" method="post">
        <p>
            <label for="texto">Introduzca un texto:</label>
            <input type="text" name="texto" id="texto" value="<?php if(isset($_POST["texto"])) echo $_POST["texto"];?>">
        </p>
        <p>
            <button type="submit" name="btnContar">Contar</button>
        </p>
    </form>
    <?php
    if(isset($_POST["btnContar"]))
    {
        echo "<h2>Respuesta:</h2>";
        echo "<p>El número de caracteres tecleado ha sido de: ".mi_strlen($_POST["texto"])."</p>";
    }
    ?>
</body>
</html>