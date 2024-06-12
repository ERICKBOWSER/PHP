<?php
if (isset($_POST["btnContEditar"])) {
    $id_usuario = $_POST["btnContEditar"];
    $usuario = $_POST["usuario"];
    $nombre = $_POST["nombre"];
    $dni = $_POST["dni"];
    $foto = $_POST["foto_bd"];
    $sexo = $_POST["sexo"];
    if (isset($_POST["subscripcion"]))
        $subscripcion = 1;
    else
        $subscripcion = 0;

    //Una vez recogido valores compruebo errores
    $error_nombre = $_POST["nombre"] == "";
    $error_usuario = $_POST["usuario"] == "";
    if (!$error_usuario) {
        $error_usuario = repetido_editando($conexion, "usuarios", "usuario", $_POST["usuario"], "id_usuario", $id_usuario);
        if (is_string($error_usuario)) {
            $conexion = null;
            session_destroy();
            die(error_page("Práctica Rec 2", "<h1>Práctica Rec 2</h1><p>" . $error_usuario . "</p>"));
        }
    }

    $error_dni = $_POST["dni"] == "" || !dni_bien_escrito($_POST["dni"]) || !dni_valido($_POST["dni"]);
    if (!$error_dni) {
        $error_dni = repetido_editando($conexion, "usuarios", "dni", strtoupper($_POST["dni"]), "id_usuario", $id_usuario);
        if (is_string($error_dni)) {
            $conexion = null;
            session_destroy();
            die(error_page("Práctica Rec 2", "<h1>Práctica Rec 2</h1><p>" . $error_dni . "</p>"));
        }
    }

    $error_foto = $_FILES["foto"]["name"] != "" && ($_FILES["foto"]["error"] || !explode(".", $_FILES["foto"]["name"]) || !getimagesize($_FILES["foto"]["tmp_name"]) || $_FILES["foto"]["size"] > 500 * 1024); //Foto no obligatoria
    //$error_foto=$_FILES["foto"]["name"]=="" || $_FILES["foto"]["error"] || !explode(".", $_FILES["foto"]["name"])|| !getimagesize($_FILES["foto"]["tmp_name"] ) || $_FILES["foto"]["size"]>500*1024;//Foto obligatoria
    $error_form = $error_nombre || $error_usuario || $error_dni || $error_foto;

    if (!$error_form) {
        //No hay errores

        try {

            if ($_POST["clave"] == "") {
                $consulta = "update usuarios set nombre=?, usuario=?, dni=?, sexo=?, subscripcion=? where id_usuario=?";
                $datos_edit = [$nombre, $usuario, strtoupper($dni), $sexo, $subscripcion, $id_usuario];
            } else {
                $consulta = "update usuarios set nombre=?, usuario=?, clave=?, dni=?, sexo=?, subscripcion=? where id_usuario=?";
                $datos_edit = [$nombre, $usuario, md5($_POST["clave"]), strtoupper($dni), $sexo, $subscripcion, $id_usuario];
            }

            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute($datos_edit);
            $sentencia = null;
        } catch (PDOException $e) {
            $sentencia = null;
            $conexion = null;
            session_destroy();
            die(error_page("Práctica Rec 2", "<h1>Práctica Rec 2</h1><p>Imposible realizar la consulta. Error:" . $e->getMessage() . "</p>"));
        }

        $mensaje = "Usuario editado con éxito";
        if ($_FILES["foto"]["name"] != "") {
            // generar nombre nueva foto
            $array_ext = explode(".", $_FILES["foto"]["name"]);
            $ext = "." . end($array_ext);
            $nombre_nuevo = "img_" . $id_usuario . $ext;
            //mover nueva foto a images
            @$var = move_uploaded_file($_FILES["foto"]["tmp_name"], "images/" . $nombre_nuevo);
            if ($var) {
                //si nombre nueva foto es distinta a $foto(bd)
                if ($foto != $nombre_nuevo) {
                    try {
                        $consulta = "update usuarios set foto=? where id_usuario=?";
                        $sentencia = $conexion->prepare($consulta);
                        $sentencia->execute([$nombre_nuevo, $id_usuario]);
                        $sentencia = null;
                        if ($foto != FOTO_DEFECTO && file_exists("images/" . $foto))
                            unlink("images/" . $foto);
                    } catch (PDOException $e) {
                        $sentencia = null;
                        $conexion = null;
                        if (file_exists("images/" . $nombre_nuevo))
                            unlink("images/" . $nombre_nuevo);
                        $mensaje = "Usuario editado con éxito pero sin cambiar a la nueva imagen por un problema con la BD del servidor";
                    }
                }
            } else
                $mensaje = "Usuario editado con éxito pero sin cambiar a la nueva imagen, ya que ésta no se ha podido mover a la carpeta destino en el servidor";
        }
        $conexion = null;
        $_SESSION["mensaje_accion"] = $mensaje;
        header("Location:index.php");
        exit();
    }
}



if (isset($_POST["btnContNuevo"])) {
    //compruebo los errores

    $error_nombre = $_POST["nombre"] == "";
    $error_usuario = $_POST["usuario"] == "";
    if (!$error_usuario) {
        $error_usuario = repetido($conexion, "usuarios", "usuario", $_POST["usuario"]);
        if (is_string($error_usuario)) {
            $conexion = null;
            session_destroy();
            die(error_page("Práctica Rec 2", "<h1>Práctica Rec 2</h1><p>" . $error_usuario . "</p>"));
        }
    }
    $error_clave = $_POST["clave"] == "";
    $error_dni = $_POST["dni"] == "" || !dni_bien_escrito($_POST["dni"]) || !dni_valido($_POST["dni"]);
    if (!$error_dni) {
        $error_dni = repetido($conexion, "usuarios", "dni", strtoupper($_POST["dni"]));
        if (is_string($error_dni)) {
            $conexion = null;
            session_destroy();
            die(error_page("Práctica Rec 2", "<h1>Práctica Rec 2</h1><p>" . $error_dni . "</p>"));
        }
    }

    $error_foto = $_FILES["foto"]["name"] != "" && ($_FILES["foto"]["error"] || !explode(".", $_FILES["foto"]["name"]) || !getimagesize($_FILES["foto"]["tmp_name"]) || $_FILES["foto"]["size"] > 500 * 1024); //Foto no obligatoria
    //$error_foto=$_FILES["foto"]["name"]=="" || $_FILES["foto"]["error"] || !explode(".", $_FILES["foto"]["name"])|| !getimagesize($_FILES["foto"]["tmp_name"] ) || $_FILES["foto"]["size"]>500*1024;//Foto obligatoria
    $error_form = $error_nombre || $error_usuario || $error_clave || $error_dni || $error_foto;

    if (!$error_form) {

        try {
            if (isset($_POST["subscripcion"]))
                $subs = 1;
            else
                $subs = 0;

            $consulta = "insert into usuarios (usuario,nombre,clave,dni,sexo,subscripcion) values (?,?,?,?,?,?)";
            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute([$_POST["usuario"], $_POST["nombre"], md5($_POST["clave"]), strtoupper($_POST["dni"]), $_POST["sexo"], $subs]);
            $sentencia = null;
        } catch (PDOException $e) {
            $sentencia = null;
            $conexion = null;
            session_destroy();
            die(error_page("Práctica Rec 2", "<h1>Práctica Rec 2</h1><p>Imposible realizar la consulta. Error:" . $e->getMessage() . "</p>"));
        }

        $mensaje = "Uusario insertado con éxito";

        if ($_FILES["foto"]["name"] != "") {
            $ultm_id = $conexion->lastInsertId();
            $array_ext = explode(".", $_FILES["foto"]["name"]);
            $ext = "." . end($array_ext);
            $nombre_nuevo = "img_" . $ultm_id . $ext;
            @$var = move_uploaded_file($_FILES["foto"]["tmp_name"], "images/" . $nombre_nuevo);
            if ($var) {
                try {

                    $consulta = "update usuarios set foto=? where id_usuario=?";
                    $sentencia = $conexion->prepare($consulta);
                    $sentencia->execute([$nombre_nuevo, $ultm_id]);
                    $sentencia = null;
                } catch (PDOException $e) {
                    if (file_exists("images/" . $nombre_nuevo))
                        unlink("images/" . $nombre_nuevo);
                    $sentencia = null;
                    $conexion = null;
                    $mensaje = "Usuario insertado con éxito pero con la imagen por defecto por un problema en la BD del servidor";
                }
            } else {
                $mensaje = "Usuario insertado con éxito pero con la imagen por defecto ya que no se ha podido mover la imagen a la carpeta destino en el servidor";
            }
        }

        $conexion = null;
        $_SESSION["mensaje_accion"] = $mensaje;
        header("Location:index.php");
        exit();
    }
}


if (isset($_POST["btnContBorrar"])) {
    try {

        $consulta = "DELETE from usuarios where id_usuario=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$_POST["btnContBorrar"]]);
        if ($_POST["foto"] != FOTO_DEFECTO && file_exists("images/" . $_POST["foto"]))
            unlink("images/" . $_POST["foto"]);

        $sentencia = null;
        $conexion = null;
        $_SESSION["mensaje_accion"] = "Usuario borrado con éxito";
        header("Location:index.php");
        exit;
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        session_destroy();
        die(error_page("Práctica Rec 2", "<h1>Práctica Rec 2</h1><p>Imposible realizar la consulta. Error:" . $e->getMessage() . "</p>"));
    }
}

if (isset($_POST["btnEditar"]) || isset($_POST["btnBorrarEditar"]) || isset($_POST["btnBorrarFoto"]) || isset($_POST["btnNoBorrarFoto"]) || isset($_POST["btnContBorrarFoto"])) {
    if (isset($_POST["btnEditar"]))
        $id_usuario = $_POST["btnEditar"];
    else
        $id_usuario = $_POST["id_usuario"];

    try {

        $consulta = "select * from usuarios where id_usuario=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$id_usuario]);
        if ($sentencia->rowCount() > 0) {
            $detalles_usu = $sentencia->fetch(PDO::FETCH_ASSOC);
            $usuario = $detalles_usu["usuario"];
            $nombre = $detalles_usu["nombre"];
            $dni = $detalles_usu["dni"];
            $foto = $detalles_usu["foto"];
            $sexo = $detalles_usu["sexo"];
            $subscripcion = $detalles_usu["subscripcion"];
        }


        $sentencia = null;
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        session_destroy();
        die(error_page("Práctica Rec 2", "<h1>Práctica Rec 2</h1><p>Imposible realizar la consulta. Error:" . $e->getMessage() . "</p>"));
    }
}

if (isset($_POST["btnDetalles"])) {
    try {

        $consulta = "select * from usuarios where id_usuario=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$_POST["btnDetalles"]]);
        if ($sentencia->rowCount() > 0)
            $detalles_usu = $sentencia->fetch(PDO::FETCH_ASSOC);
        else
            $detalles_usu = false;

        $sentencia = null;
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        session_destroy();
        die(error_page("Práctica Rec 2", "<h1>Práctica Rec 2</h1><p>Imposible realizar la consulta. Error:" . $e->getMessage() . "</p>"));
    }
}


//// Consulta para obtener los usuarios a listar en la Tabla








try {

    $consulta = "SELECT * FROM usuarios WHERE tipo<>'admin'";
    $sentencia = $conexion->prepare($consulta);
    $sentencia->execute();
} catch (PDOException $e) {
    $sentencia = null;
    $conexion = null;
    session_destroy();
    die(error_page("Práctica Rec 2", "<h1>Práctica Rec 2</h1><p>Imposible realizar la consulta. Error:" . $e->getMessage() . "</p>"));
}
$usuarios = $sentencia->fetchAll(PDO::FETCH_ASSOC);
$sentencia = null;
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Práctica Rec 2</title>
    <style>
        .error {
            color: red
        }

        .en_linea {
            display: inline
        }

        .enlace {
            border: none;
            background: none;
            color: blue;
            text-decoration: underline;
            cursor: pointer
        }

        table {
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid black
        }

        th {
            background-color: #CCC
        }

        .reducida {
            height: 100px
        }

        .img_editar {
            width: 30%
        }

        .centrar {
            width: 80%;
            margin: 0 auto;
        }

        .mensaje {
            font-size: 1.25rem;
            color: blue
        }

        #t_editar,
        #t_editar td {
            border: none
        }

        .centrado {
            text-align: center;
        }
    </style>
</head>

<body>
    <h1>Práctica Rec 2</h1>
    <div>
        Bienvenido <strong><?php echo $datos_usuario_log["usuario"]; ?></strong> -
        <form class="en_linea" action="index.php" method="post">
            <button class="enlace" name="btnSalir" type="submit">Salir</button>
        </form>
    </div>

    <?php
    if (isset($_POST["btnBorrar"])) {
        echo "<div class='centrar centrado'>";
        echo "<form method='post' action='index.php'>";
        echo "<input type='hidden' name='foto' value='" . $_POST["foto"] . "'/>";
        echo "<h2>Borrado del usuario con id: " . $_POST["btnBorrar"] . "</h2>";
        echo "<p>¿ Estás seguro ?</p>";
        echo "<p><button type='submit' name='btnContBorrar' value='" . $_POST["btnBorrar"] . "'>Sí</button> <button type='submit'>No</button></p>";
        echo "</form>";
        echo "</div>";
    }

    if (isset($_POST["btnDetalles"])) {
        echo "<div class='centrar centrado'>";
        echo "<h3>Detalles del usuario con id:" . $_POST["btnDetalles"] . "</h3>";
        if ($detalles_usu) {
            echo "<p><strong>Nombre: </strong>" . $detalles_usu["nombre"] . "</p>";
            echo "<p><strong>Usuario: </strong>" . $detalles_usu["usuario"] . "</p>";
            echo "<p><strong>Contraseña: </strong>*********</p>";
            echo "<p><strong>DNI: </strong>" . $detalles_usu["dni"] . "</p>";
            echo "<p><strong>Sexo: </strong>" . $detalles_usu["sexo"] . "</p>";
            if ($detalles_usu["subscripcion"])
                echo "<p><strong>Subscripción: </strong>Sí</p>";
            else
                echo "<p><strong>Subscripción: </strong>No</p>";

            echo "<p><strong>Foto: </strong><img class='reducida' src='images/" . $detalles_usu["foto"] . "' alt='Foto' title='Foto'/></p>";
        } else
            echo "<p>El usuario seleccionado ya no se encuentra en la BD</p>";
        echo "</div>";
    }

    if (isset($_POST["btnEditar"]) || isset($_POST["btnContEditar"]) || isset($_POST["btnBorrarEditar"]) || isset($_POST["btnBorrarFoto"]) || isset($_POST["btnNoBorrarFoto"]) || isset($_POST["btnContBorrarFoto"])) {
        if (isset($_POST["btnEditar"])) {
            $id_usuario = $_POST["btnEditar"];
        } else {
            $id_usuario = $_POST["id_usuario"];
        }


        echo "<h2>Detalles del usuario con id:" . $id_usuario . "</h2>";
        if (!isset($usuario)) {
            echo "<p>El usuario seleccionado ya no se encuentra en la BD</p>";
        } else {

            //Por aquí el formulario de edición
    ?>
            <form action="index.php" method="post" enctype="multipart/form-data">
                <table id="t_editar" class='sin_bordes'>
                    <tr>
                        <td>
                            <p>
                                <label for="usuario">Usuario: </label><br>
                                <input type="text" id="usuario" name="usuario" value="<?php echo $usuario; ?>" placeholder="Usuario...">
                                <?php
                                if (isset($_POST["btnContEditar"]) && $error_usuario) {
                                    if ($_POST["usuario"] == "")
                                        echo "<span class='error'> Campo vacío</span>";
                                    else
                                        echo "<span class='error'> Usuario repetido</span>";
                                }

                                ?>
                            </p>
                            <p>
                                <label for="nombre">Nombre: </label><br>
                                <input type="text" id="nombre" name="nombre" value="<?php echo $nombre; ?>" placeholder="Nombre...">
                                <?php
                                if (isset($_POST["btnContEditar"]) && $error_nombre)
                                    echo "<span class='error'> Campo vacío</span>";
                                ?>
                            </p>
                            <p>
                                <label for="clave">Contraseña: </label><br>
                                <input type="password" id="clave" name="clave" placeholder="Teclee nueva contraseña...">
                            </p>
                            <p>
                                <label for="dni">DNI: </label><br>
                                <input type="text" id="dni" name="dni" value="<?php echo $dni; ?>" placeholder="DNI: 11223344Z">
                                <?php
                                if (isset($_POST["btnContEditar"]) && $error_dni) {
                                    if ($_POST["dni"] == "")
                                        echo "<span class='error'> Campo vacío</span>";
                                    else if (!dni_bien_escrito($_POST["dni"]))
                                        echo "<span class='error'> DNI no está bien escrito</span>";
                                    else if (!dni_valido($_POST["dni"]))
                                        echo "<span class='error'> DNI no es válido</span>";
                                    else
                                        echo "<span class='error'> DNI repetido</span>";
                                }
                                ?>
                            </p>
                            <p>
                                <label>Sexo: </label><br>
                                <input type="radio" id="hombre" name="sexo" value="hombre" <?php if ($sexo == "hombre") echo "checked"; ?>>
                                <label for="hombre">Hombre: </label><br>
                                <input type="radio" id="mujer" name="sexo" value="mujer" <?php if ($sexo == "mujer") echo "checked"; ?>>
                                <label for="mujer">Mujer: </label><br>
                            </p>
                            <p>
                                <label for="foto">Cambiar la foto (Máx. 500 KB)</label>
                                <input type="file" name="foto" id="foto" accept="image/*">
                                <?php
                                if (isset($_POST["btnContEditar"]) && $error_foto) {
                                    if ($_FILES["foto"]["error"])
                                        echo "<span class='error'> Error en la subida del fichero al servidor </span>";
                                    else if (!explode(".", $_FILES["foto"]["name"]))
                                        echo "<span class='error'> El fichero subido debe tener extensión </span>";
                                    else if (!getimagesize($_FILES["foto"]["tmp_name"]))
                                        echo "<span class='error'> El fichero subido debe ser una imagen</span>";
                                    else
                                        echo "<span class='error'> El tamaño del fichero no debe superar los 500 KB</span>";
                                }
                                ?>
                            </p>
                            <p>
                                <input type="checkbox" id="subsc" name="subscripcion" <?php if ($subscripcion) echo "checked"; ?>>
                                <label for="subsc">Suscribirme al boletín de novedades: </label><br>
                            </p>

                            <p>
                                <input type="hidden" name="foto_bd" value='<?php echo $foto; ?>'>
                                <input type="hidden" name="id_usuario" value="<?php echo $id_usuario; ?>">
                                <button type="submit" name="btnContEditar" value='<?php echo $id_usuario; ?>'>Guardar Cambios</button>
                                <button type="submit" name="btnBorrarEditar" value='<?php echo $id_usuario; ?>'>Borrar los datos introducidos</button>
                            </p>
                        </td>
                        <td>
                            <p class='centrado'>
                                <?php
                                if (isset($_POST["btnContBorrarFoto"])) {
                                    unlink("images/" . $foto);

                                    try {
                                        $consulta = "update usuarios set foto=? where id_usuario=?";
                                        $sentencia = $conexion->prepare($consulta);
                                        $sentencia->execute([""]);
                                        $sentencia = null;
                                    } catch (PDOException $e) {
                                        $sentencia = null;
                                        $conexion = null;
                                        session_destroy();
                                        die(error_page("Práctica Rec 2", "<h1>Práctica Rec 2</h1><p>Imposible realizar la consulta. Error:" . $e->getMessage() . "</p>"));
                                    }
                                }
                                ?>
                                <img class='img_editar' src='images/<?php echo $foto; ?>' title='Foto' alt='Foto'><br>
                                <?php
                                if (isset($_POST["btnBorrarFoto"]))
                                    echo "¿Estás seguro que quieres borra la foto?<br><br><button name='btnContBorrarFoto'>Si</button><button name='btnNoBorrarFoto'>No</button>";
                                elseif ($foto != FOTO_DEFECTO)
                                    echo '<button name="btnBorrarFoto">Borrar Foto</button>';
                                ?>
                            </p>
                        </td>
                    </tr>
                </table>
            </form>

        <?php
        }
    }


    if (isset($_POST["btnNuevo"]) || isset($_POST["btnBorrarNuevo"]) || isset($_POST["btnContNuevo"])) {
        if (isset($_POST["btnBorrarNuevo"]))
            unset($_POST);
        ?>
        <h3>Nuevo Usuario</h3>
        <form action="index.php" method="post" enctype="multipart/form-data">
            <p>
                <label for="usuario">Usuario: </label><br>
                <input type="text" id="usuario" name="usuario" value="<?php if (isset($_POST["usuario"])) echo $_POST["usuario"]; ?>" placeholder="Usuario...">
                <?php
                if (isset($_POST["btnContNuevo"]) && $error_usuario) {
                    if ($_POST["usuario"] == "")
                        echo "<span class='error'> Campo vacío</span>";
                    else
                        echo "<span class='error'> Usuario repetido</span>";
                }

                ?>
            </p>
            <p>
                <label for="nombre">Nombre: </label><br>
                <input type="text" id="nombre" name="nombre" value="<?php if (isset($_POST["nombre"])) echo $_POST["nombre"]; ?>" placeholder="Nombre...">
                <?php
                if (isset($_POST["btnContNuevo"]) && $error_nombre)
                    echo "<span class='error'> Campo vacío</span>";
                ?>
            </p>
            <p>
                <label for="clave">Contraseña: </label><br>
                <input type="password" id="clave" name="clave" placeholder="Contraseña...">
                <?php
                if (isset($_POST["btnContNuevo"]) && $error_clave)
                    echo "<span class='error'> Campo vacío</span>";
                ?>
            </p>
            <p>
                <label for="dni">DNI: </label><br>
                <input type="text" id="dni" name="dni" value="<?php if (isset($_POST["dni"])) echo $_POST["dni"]; ?>" placeholder="DNI: 11223344Z">
                <?php
                if (isset($_POST["btnContNuevo"]) && $error_dni) {
                    if ($_POST["dni"] == "")
                        echo "<span class='error'> Campo vacío</span>";
                    else if (!dni_bien_escrito($_POST["dni"]))
                        echo "<span class='error'> DNI no está bien escrito</span>";
                    else if (!dni_valido($_POST["dni"]))
                        echo "<span class='error'> DNI no es válido</span>";
                    else
                        echo "<span class='error'> DNI repetido</span>";
                }
                ?>
            </p>
            <p>
                <label>Sexo: </label><br>
                <input type="radio" id="hombre" name="sexo" value="hombre" <?php if (!isset($_POST["sexo"]) || (isset($_POST["sexo"]) && $_POST["sexo"] == "hombre")) echo "checked"; ?>>
                <label for="hombre">Hombre: </label><br>
                <input type="radio" id="mujer" name="sexo" value="mujer" <?php if (isset($_POST["sexo"]) && $_POST["sexo"] == "mujer") echo "checked"; ?>>
                <label for="mujer">Mujer: </label><br>
            </p>
            <p>
                <label for="foto">Incluir mi foto (Máx. 500 KB)</label>
                <input type="file" name="foto" id="foto" accept="image/*">
                <?php
                if (isset($_POST["btnContNuevo"]) && $error_foto) {
                    if ($_FILES["foto"]["error"])
                        echo "<span class='error'> Error en la subida del fichero al servidor </span>";
                    else if (!explode(".", $_FILES["foto"]["name"]))
                        echo "<span class='error'> El fichero subido debe tener extensión </span>";
                    else if (!getimagesize($_FILES["foto"]["tmp_name"]))
                        echo "<span class='error'> El fichero subido debe ser una imagen</span>";
                    else
                        echo "<span class='error'> El tamaño del fichero no debe superar los 500 KB</span>";
                }
                ?>
            </p>
            <p>
                <input type="checkbox" id="subsc" name="subscripcion" <?php if (isset($_POST["subscripcion"])) echo "checked"; ?>>
                <label for="subsc">Suscribirme al boletín de novedades: </label><br>
            </p>
            <p>
                <button type="submit" name="btnContNuevo">Guardar Cambios</button>
                <button type="submit" name="btnBorrarNuevo">Borrar los datos introducidos</button>
            </p>
        </form>
    <?php
    }

    if (isset($_SESSION["mensaje_accion"])) {
        echo "<p class='mensaje'>" . $_SESSION["mensaje_accion"] . "</p>";
        unset($_SESSION["mensaje_accion"]);
    }

    echo "<h2>Listado de los usuarios (no admin)</h2>";
    echo "<table class='centrar centrado'>";
    echo "<tr><th>#</th><th>Foto</th><th>Nombre</th><th><form action='index.php' method='post'><button class='enlace' type='submit' name='btnNuevo'>Usuario+</button></form></th></tr>";
    foreach ($usuarios as $tupla) {
        echo "<tr>";
        echo "<td>" . $tupla["id_usuario"] . "</td>";
        echo "<td><img class='reducida' src='images/" . $tupla["foto"] . "' alt='Foto' title='Foto'></td>";
        echo "<td><form action='index.php' method='post'><button class='enlace' type='submit' value='" . $tupla["id_usuario"] . "' name='btnDetalles'>" . $tupla["nombre"] . "</button></form></td>";
        echo "<td><form action='index.php' method='post'><input type='hidden' name='foto' value='" . $tupla["foto"] . "'/><button class='enlace' type='submit' name='btnBorrar' value='" . $tupla["id_usuario"] . "'>Borrar</button> - <button class='enlace' type='submit' name='btnEditar' value='" . $tupla["id_usuario"] . "'>Editar</button></form></td>";
        echo "</tr>";
    }
    echo "</table>";

    ?>
</body>

</html>