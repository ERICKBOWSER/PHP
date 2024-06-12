<!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Examen3 Curso 23-24</title>
        <style>
            .enlinea{display:inline}
            .enlace{border:none;background:none;text-decoration:underline;color:blue;cursor:pointer}
            img{height:200px}
            p{text-align:center;width:30%;margin-top:2.5%;margin-left:2.5%;float:left}
        
        </style>
    </head>
    <body>
        <h1>Librería</h1>
        <div>Bienvenido <strong><?php echo $datos_usuario_logueado["lector"];?></strong> - 
            <form class='enlinea' action="index.php" method="post">
                <button class='enlace' type="submit" name="btnSalir">Salir</button>
            </form>
        </div>
        <?php
        require "vistas/vista_libros_atres.php";
        ?>
    </body>
    </html>