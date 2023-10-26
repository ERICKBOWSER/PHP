<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Ejercicio 3</h1>
    <form action="ejer3.php" method="post">
        <p>
            <label for="sep">Elija separador</label>
            <select name="sep" id="sep">
                <option value=",">, (coma)</option>
                <option value=";">; (punto y coma)</option>
                <option value=" "> (espacio)</option>
                <option value=":">: (dos puntos)</option>
            </select>   
        </p>
        <p>
            <label for="texto">Introduzca una frase</label>
            <input type="text" name="texto" id="texto" value="<?php if(isset($_POST["text"])) echo $_POST["texto"];?>">
        </p>
        <p>
            <button type="submit" name="btnContar">Contar</button>
        </p>
    </form>
</body>
</html>