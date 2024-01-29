<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>App Login SW</title>
    <style>
        .enlace{background: none;
        border: none;
        text-decoration: underline;
        color: blue;
        cursor: pointer;        
        }
        .enlinea{display: inline;}
    </style>
</head>
<body>
    <h1>App Login SW</h1>
    <div>
        <p>Bienvenido <strong><?php echo $datosUsuarioLog->usuario;?></strong> - <form class="enlinea" action = "index.php" method="post">
            <button type="submit" name="btnSalir">Salir</button>
        </form>
        </p>
    </div>
</body>
</html>