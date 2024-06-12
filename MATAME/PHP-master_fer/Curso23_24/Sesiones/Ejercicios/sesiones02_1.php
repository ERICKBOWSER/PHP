<?php
session_name("sesiones02");
session_start();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .centrado{text-align: center;}
    </style>
</head>

<body>
    <h1 class="centrado">FORMULARIO NOMBRE 1 (FORMULARIO)</h1>
    <?php
    if(isset($_SESSION["nombre"])){
        echo "<p>Su nombre es: <strong>".$_SESSION["nombre"]."</strong></p>";
    }
    ?>
    <form action="sesiones01_2.php" method="post">
        <p><label for="nombre">Escriba su nombre</label></p>
        <label><strong>Nombre:</strong></label>
        <input type="text" name="nombre" id="nombre" />
        <?php
    if(isset($_SESSION["error"])){
        echo "<span class='error'>".$_SESSION["error"]."</span>";
        session_destroy();
    }
        ?>
        <p>
            <button type="submit" name="btnSig">Siguiente</button>
            <button type="submit" name="btnBorrar">Borrar</button>
        </p>

    </form>
</body>

</html>