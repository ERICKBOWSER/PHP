<?php
    if(isset($_POST["btnNuevoUsuario"]) || isset($_POST["continuar"])){


        // Comprobamos si hay errrores
        if(isset($_POST["continuar"])){
            $errorNombre = $_POST["nombre"] == "";
            $errorUsuario = $_POST["usuario"] == "";
            $errorClave = $_POST["password"] == "";
            $errorEmail = $_POST["email"] == "" || 
                !filter_var($_POST["email"], FILTER_VALIDATE_EMAIL) // VALIDA EL EMAIL

            $errorForm = $errorNombre || $errorClave || $errorEmail || $errorUsuario;

            // SI NO HAY ERROR AHÍ SE HACE LA INSERCIÓN
            if(!$errorForm)
        }




    // DADO QUE HEMOS SALTADO A OTRA PAG HAY QUE VOLVER A ABRIR LA CONEXIÓN CON LA BBDD

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Nuevo Usuario</h1>
    <form action="usuario_nuevo.php" method="post">
        <p>
            <label for="nombre">Nombre: </label><br/>
            <input type="text" name="nombre" id="nombre" maxlength="30" value=""/>
        </p>
        <p>
            <label for="usuario">Usuario</label><br/>
            <input type="text" name="usuario" id="usuario" maxlength="20" value=""/>
        </p>
        <p>
            <label for="password">Contraseña: </label><br/>
            <input type="password" name="password" id="password" maxlength="15" value=""/>
        </p>
        <p>
            <label for="email">Email: </label><br/>
            <input type="email" name="email" id="email" maxlength="50" value=""/>
        </p>
        <p>
            <button type="submit" name="continuar" id="continuar">Continuar</button>
            <button type="submit" name="volver" id="volver">Volver</button>
        </p>
    </form>
</body>
</html>

<?php
}else{
    header("Location: index.php"); // NO PUEDE ESTAR DESPUÉS DE UN HTML, HAY QUE HACERLO SIEMPRE ANTES DEL HTML
    exit();
}