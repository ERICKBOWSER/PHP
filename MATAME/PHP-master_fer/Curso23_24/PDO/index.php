<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TEORIA PDO</title>
</head>
<body>
    <h1>Teoria PDO</h1>
    <?php
    define("SERVIDOR_BD","localhost");
    define("USUARIO_BD","jose");
    define("CLAVE_BD","josefa");
    define("NOMBRE_BD","bd_foro");

    try{
        $conexion=mysqli_connect(SERVIDOR_BD,USUARIO_BD,CLAVE_BD,NOMBRE_BD);
        mysqli_set_charset($conexion,"utf8");
    }
    catch(Exception $e)
    {
        die("<p>No se ha podido conector a la base de datos ".$e->getMessage()."</p></body></html>");

    }

    echo "TODO BIEN";
    ?>
</body>
</html>