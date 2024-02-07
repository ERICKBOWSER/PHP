<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Libreria-admin</h1>
    <div>Bienvenido <strong><?php echo $datosUsuarioLog->usuario ->lector;?></strong>-
    <form class="enlinea" action="index.php" method="post">
        <button class="enlace" type="submit">salir</button>
    </form>
</body>
</html>