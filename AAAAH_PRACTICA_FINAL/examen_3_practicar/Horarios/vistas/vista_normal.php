<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examen 3</title>
    <style>
            .enlinea{display:inline}
            .enlace{border:none;background:none;text-decoration:underline;color:blue;cursor:pointer}
        </style>
</head>
<body>
    <h1>Examen 3 PHP<h1>
    <div>Bienvenido <strong><?php echo $datos_usuario_log->usuario;?></strong> -
        <form class="enlinea" action="index.php" method="post">
            <button class="enlace" type="submit" name="btnSalir">Salir</button>
        </form>
    </div>
    <?php 
    require "vistas/vista_horarios.php";
    ?>
</body>
</html>