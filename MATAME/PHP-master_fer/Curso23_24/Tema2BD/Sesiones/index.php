<?php
    session_start();
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
    if(!isset($_SESSION["nombre"])){
        $_SESSION["nombre"]="Miguel Santos";
        $_SESSION["clave"]=md5("123456");
    }
    ?>
    <p><a href="recibido.php">Ver datos</a></p>

        <form action="recibido.php" method="post">
            <button type="submit" name="btnBorrarSesion">Borrar datos sesion</button>
        </form>
</body>
</html>