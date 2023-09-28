<?php
    if(isset($_POST["btnBorrar"])){
        unset($_POST);
    }

    if(isset($_POST["submit"])){
        $error_primera = $_POST["primera"] == "";
        $error_segunda = $_POST["segunda"] == "";

        $error_form = $error_primera || $error_segunda;
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
    <h1> Ripios - Formulario</h1>
    <form action="recogida.php" method="post" enctype="multipart/form-data">
        <p> Dime dos palabras y te diré si riman o no</p>
        <p>
            <label for="primera">Primera palabra</label>
            <input type="text" name="primera" id="primera"/>
        </p>
        <p>
            <label for="segunda">Segunda palabra</label>
            <input type="text" name="segunda" id="segunda"/>
        </p>
        <p>
            <input type="submit" name="comparar" id="comparar" value="Comparar"/>
        </p>
    </form>
</body>
</html>