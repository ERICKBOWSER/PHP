<?php

    function errorPage($title, $body){
        // SE HACE CON COMILLAS SIMPLES PORQUE HAY COMILLAS DOBLES DENTRO DEL HTML
        $page = '<!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>' . $title . '</title>
        </head>
        <body>' . $body . '</body>
        </html>';
        return $page;
    }

    function repetido($conexion, $tabla, $columna, $valor){

        try{
            $consulta = "SELECT * FROM " . $tabla . " WHERE " . $columa . "='" . $valor . "'"; //PUEDE IR FUERA

            $resultado = mysqli_query($conexion, $consulta);
            $respuesta = mysqli_num_rows($resultado) > 0;
            mysqli_free_result($conexion);


        } catch(Exception $e){
        
            mysqli_close($conexion); // SI FALLA LA CONSULTA HAY QUE CERRAR LA CONEXIÓN OBLIGATORIAMENTE

            die(errorPage("Práctica 1º CRUD", "<h1>Práctica 1º CRUD</h1><p>No se ha podido realizar la consulta: " . $e->getMessage() . "</p></body></html>"));
        } 

        return $respuesta;
    }


    if(isset($_POST["btnNuevoUsuario"]) || isset($_POST["continuar"])){


        // Comprobamos si hay errrores
        if(isset($_POST["continuar"])){
            $errorNombre = $_POST["nombre"] == "" || strlen($_POST["nombre"] >30);
            $errorUsuario = $_POST["usuario"] == "" || $_POST["usuario"] > 20;
            if(!$errorUsuario){
                try{
                    $conexion = mysqli_connect("localhost", "jose", "josefa", "bd_foro");
        
                    mysqli_set_charset($conexion, "utf8"); // Establecer el lector
        
                } catch(Exception $e){
                    // NUNCA PUEDE IR UN mysqli_close() PORQUE NO SE HA HECHO NI LA CONEXIÓN DE LA BBDD
                    die(errorPage("Práctica 1º CRUD", "<h1>Práctica 1º CRUD</h1><p>No ha podido conectarse a la BBDD: " . $e->getMessage() . "</p></body></html>"));
                } 

                $errorUsuario = repetido($conexion, "usuarios", "usuario", $_POST["usuario"]);

                if(is_string($errorUsuario)){
                    die($errorUsuario);
                }
/*
                try{
                    $consulta = "SELECT * FROM usuarios WHERE usuario='" . $_POST["usuario"] . "'"; //PUEDE IR FUERA
        
                    $resultado = mysqli_query($conexion, $consulta);
        
        
        
                } catch(Exception $e){
                
                    mysqli_close($conexion); // SI FALLA LA CONSULTA HAY QUE CERRAR LA CONEXIÓN OBLIGATORIAMENTE

                    die(errorPage("Práctica 1º CRUD", "<h1>Práctica 1º CRUD</h1><p>No se ha podido realizar la consulta: " . $e->getMessage() . "</p></body></html>"));
                } 
                $errorUsuario = mysqli_num_rows($resultado) > 0;
                mysqli_free_result($resultado); */
            }

            $errorClave = $_POST["password"] == "" || strlen($_POST["password"] > 15);
            $errorEmail = $_POST["email"] == "" || strlen($_POST["email"] > 50) ||
                !filter_var($_POST["email"], FILTER_VALIDATE_EMAIL) // VALIDA EL EMAIL

            if(!$errorEmail){
                if(!isset(!$conexion)){ // SI NO HAY CONEXIÓN LA CREA
                    try{
                        $conexion = mysqli_connect("localhost", "jose", "josefa", "bd_foro");
            
                        mysqli_set_charset($conexion, "utf8"); // Establecer el lector
            
                    } catch(Exception $e){
                        // NUNCA PUEDE IR UN mysqli_close() PORQUE NO SE HA HECHO NI LA CONEXIÓN DE LA BBDD
                        die(errorPage("Práctica 1º CRUD", "<h1>Práctica 1º CRUD</h1><p>No ha podido conectarse a la BBDD: " . $e->getMessage() . "</p></body></html>"));
                    }                   
                }
                $errorEmail = repetido($conexion, "usuarios", "email", $_POST["email"]);

                if(is_string($errorEmail)){
                    die($errorEmail);
                }
            }

            $errorForm = $errorNombre || $errorClave || $errorEmail || $errorUsuario;

            // SI NO HAY ERROR AHÍ SE HACE LA INSERCIÓN
            if(!$errorForm){
                echo "Inserto en BD y salto a index.php";
                // Inserto en la bbdd y salto a index

                try{
                    $consulta = "INSERT INTO usuarios (nombre, usuario, clave, email) VALUES('" . $_POST["nombre"] . "', '" . $_POST["usuario"] . "', '" . md5($_POST["clave"]) . "', '" . $_POST["email"] . "')";
                    mysqli_query($conexion, $consulta);

                } catch(Exception $e){
                    
                        mysqli_close($conexion); // SI FALLA LA CONSULTA HAY QUE CERRAR LA CONEXIÓN OBLIGATORIAMENTE
    
                        die(errorPage("Práctica 1º CRUD", "<h1>Práctica 1º CRUD</h1><p>No se ha podido realizar la consulta: " . $e->getMessage() . "</p></body></html>"));
                    } 

                mysqli_close($conexion);

                header("Location:index.php");
                exit();
            }

            // Por aquí continuo sólo si hay errores en el formulario
            // Si no hay errores de conexión
            if(isset($conexion)){
                mysqli_close($conexion);
            }
        }




    // DADO QUE HEMOS SALTADO A OTRA PAG HAY QUE VOLVER A ABRIR LA CONEXIÓN CON LA BBDD

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .error{color: red}

    </style>
</head>
<body>
    <h1>Nuevo Usuario</h1>
    <form action="usuario_nuevo.php" method="post">
        <p>
            <label for="nombre">Nombre: </label><br/>
            <input type="text" name="nombre" id="nombre" maxlength="30" value="<?php if(isset($_POST["nombre"])) echo $_POST["nombre"]; ?>"/>
            <?php
                if(isset($_POST["continuar"]) && $errorNombre){
                    if($_POST["nombre"] == ""){
                        echo "<span class='error'>Campo vacío</span>";
                    }else{
                        echo "<span class='error'>Has tecleado más de 30 caracteres</span>";
                    }
                }
            ?>
        </p>
        <p>
            <label for="usuario">Usuario</label><br/>
            <input type="text" name="usuario" id="usuario" maxlength="20" value="<?php if(isset($_POST["usuario"])) echo $_POST["usuario"]; ?>"/>
            <?php
                if(isset($_POST["continuar"]) && $errorUsuario){
                    if($_POST["usuario"] == ""){
                        echo "<span class='error'>Campo vacío</span>";
                    }elseif(strlen($_POST["usuario"]) > 30){
                        echo "<span class='error'>Has tecleado más de 20 caracteres</span>";
                    }
                }
            ?>
        </p>
        <p>
            <label for="password">Contraseña: </label><br/>
            <input type="password" name="password" id="password" maxlength="15" value=""/>
            <?php
                if(isset($_POST["continuar"]) && $errorClave){
                    if($_POST["password"] == ""){
                        echo "<span class='error'>Campo vacío</span>";
                    }else{
                        echo "<span class='error'>Has tecleado más de 15 caracteres</span>";
                    }
                }
            ?>
        </p>
        <p>
            <label for="email">Email: </label><br/>
            <input type="email" name="email" id="email" maxlength="50" value="<?php if(isset($_POST["email"])) echo $_POST["email"]; ?>"/>
            <?php
                if(isset($_POST["continuar"]) && $errorEmail){
                    if($_POST["email"] == ""){
                        echo "<span class='error'>Campo vacío</span>";
                    }elseif(strlen($_POST["email"]) > 50){
                        echo "<span class='error'>Has tecleado más de 50 caracteres</span>";
                    }elseif(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
                            echo "<span class='error'>Email sintaticamente incorrecto</span>";
                    }else{
                        echo "<span class='error'>Email incorrecto</span>";
                    }
                }
            ?>
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