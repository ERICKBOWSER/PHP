<?php
///Consulta para traerse los libros
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Práctica Rec 2b</title>
    <style>
        .en_linea{display:inline}
        .enlace{border:none;background:none;color:blue;text-decoration:underline;cursor:pointer}
        .mensaje{font-size:1.25em;color:blue}
    </style>
</head>
<body>
    <h1>Librería</h1>
    <div>
        Bienvenido <strong><?php echo $datos_usuario_log["lector"];?></strong> - 
        <form class="en_linea" action="index.php" method="post">
            <button class="enlace" name="btnSalir" type="submit">Salir</button>
        </form>
    </div>
    <h2>Listado de Libros</h2>
    <!-- Aquí se mostrarían los libros de tres en tres -->
</body>
</html>