<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Normal</title>
    <style>
        .en_linea{display: inline;}
        .enlace{border: none; background-color: none; color: blue; text-decoration: underline; cursor: pointer;}
    </style>
</head>
<body>
    <h1>Práctica 2</h1>
    <div>
        Bienvenido <strong><?php echo $datos_usuario_log["usuario"];?></strong>
        <form class="en_linea" action="index.php" method="post">
            <button class="enlae" name="btnSalir" type="submit">Salir</button>
        </form>
    </div>
</body>
</html>