<?php
session_name("sesiones01");
session_start();

if (isset($_POST["nombre"]) && $_POST["nombre"] != "") {
    if ($_POST["nombre"] == "") {

        unset($_SESSION["nombre"]);
    } else {
        $_SESSION["nombre"] = $_POST["nombre"];
    }
}


if (isset($_POST["btnBorrar"])) {

    session_destroy();
    header("Location:sesiones01_1.php");
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .centrado {
            text-align: center;
        }
    </style>
</head>

<body>
    <h1 class="centrado">FORMULARIO NOMBRE 1 (RESULTADO)</h1>
    <?php
    if (isset($_SESSION["nombre"])) {

        echo "<p>Su nombre es: <strong>" . $_SESSION["nombre"] . "</strong></p>";
    } else {
        echo "<p>No has tecleado nada en primera pagina</p>";
    }
    ?>
    <p><a href="sesiones01_1.php">Volver a la primera pagina</a></p>
</body>

</html>