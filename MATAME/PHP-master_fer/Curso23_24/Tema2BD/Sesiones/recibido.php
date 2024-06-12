<?php
    session_start();
    if(isset($_POST["btnBorrarSesion"])){
        session_unset();
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
    <h1>Teoria Sesiones</h1>
    <?php
    if(isset($_SESSION["nombre"])){
        echo "<strong>Nombre: </strong>".$_SESSION["nombre"]."<br>";
        echo "<strong>Nombre: </strong>".$_SESSION["clave"]."<br>";

    }else{
        echo "<p>Se han borrado los valores de sesion</p>";
    }
       
    ?>
    <p><a href="index.php">Volver</a></p>

</body>
</html>