<!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Examen SW 22_23</title>
        <style>
            .enlinea{display:inline}
            .enlace{border:none;background:none;text-decoration:underline;color:blue;cursor:pointer}
        </style>
    </head>
    <body>
        <h1>Librería - Vista Admin</h1>
        <div>Bienvenido <strong><?php echo $datos_usuario_log->lector;?></strong> - 
            <form class='enlinea' action="../index.php" method="post">
                <button class='enlace' type="submit" name="btnSalir">Salir</button>
            </form>
        </div>
    </body>
    </html>