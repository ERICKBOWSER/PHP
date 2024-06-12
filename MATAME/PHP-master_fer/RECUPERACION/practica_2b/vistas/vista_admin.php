<?php
if (isset($_POST["btnAgregar"])) {
    $error_referencia = $_POST["referencia"] == "" || !is_numeric($_POST["referencia"]) || $_POST["referencia"] < 0;
    if (!$error_referencia) {

        $error_referencia = repetido($conexion, "libros", "referencia", $_POST["referencia"]);

        if (is_string($error_referencia)) {

            session_destroy();
            $conexion = null;
            die(error_page("Examen3 Curso 23-24", "<h1>Librería</h1><p>Error en la consulta: " . $error_referencia . "</p>"));

        }
    }

    $error_titulo = $_POST["titulo"] == "";
    $error_autor = $_POST["autor"] == "";
    $error_descripcion = $_POST["descripcion"] == "";
    $error_precio = $_POST["precio"] == "" || !is_numeric($_POST["precio"]) || $_POST["precio"] <= 0;
    $array_nombre = explode(".", $_FILES["portada"]["name"]);
    $error_portada = $_FILES["portada"]["name"] != "" && ($_FILES["portada"]["error"] || !$array_nombre || !getimagesize($_FILES["portada"]["tmp_name"]) || $_FILES["portada"]["size"] > 750 * 1024);

    $error_form = $error_referencia || $error_titulo || $error_autor || $error_descripcion || $error_precio || $error_portada;

    if (!$error_form) {

        try {

            $consulta = "insert into libros(referencia, titulo, autor,descripcion,precio) values(?,?,?,?,?)";
            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute([$_POST["referencia"], $_POST["titulo"], $_POST["autor"], $_POST["descripcion"], $_POST["precio"]]);

        } catch (Exception $e) {

            session_destroy();
            $conexion = null;
            $sentencia = null;
            die(error_page("Examen3 Curso 23-24", "<h1>Librería</h1><p>Error en la consulta: " . $e->getMessage() . "</p>"));

        }

        $_SESSION["accion"] = "Libro agregado con éxito";

        if ($_FILES["portada"]["name"] != "") {

            $ext = end($array_nombre);
            $nombre_nuevo = "img" . $_POST["referencia"] . "." . $ext;
            @$var = move_uploaded_file($_FILES["portada"]["tmp_name"], "../img/" . $nombre_nuevo);

            if ($var) {
                try {

                    $consulta = "update libros set portada=? where referencia=?";
                    $sentencia = $conexion->prepare($consulta);
                    $sentencia->execute([$nombre_nuevo, $_POST["referencia"]]);

                } catch (Exception $e) {

                    unlink("../img/" . $nombre_nuevo);
                    session_destroy();
                    $conexion = null;
                    $sentencia = null;
                    die(error_page("Examen3 Curso 23-24", "<h1>Librería</h1><p>Error en la consulta: " . $e->getMessage() . "</p>"));

                }
            } else

                $_SESSION["accion"] = "Libro agregado con éxito pero con la imagen por defecto por no poder mover la imagen subida a la carpeta destino";
        }

        $conexion = null;
        $sentencia = null;
        header("Location:gest_libros.php");
        exit;
    }
}


if (isset($_POST["btnBorrar"])) {

    try {

        $consulta = "delete from libros where referencia=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$_POST['btnBorrar']]);

    } catch (Exception $e) {

        session_destroy();
        $conexion = null;
        $sentencia = null;

        die(error_page("Examen3 Curso 23-24", "<h1>Librería</h1><p>Error en la consulta: " . $e->getMessage() . "</p>"));
    }

    $_SESSION["accion"] = "EL libro con referencia " . $_POST["btnBorrar"] . " se ha borrado con éxito";
    $conexion = null;
    $sentencia = null;
    header("Location:gest_libros.php");
    exit;
}

if (isset($_POST["btnEditar"])) {
    
    $_SESSION["accion"] = "EL libro con referencia " . $_POST["btnEditar"] . " se ha editado con éxito";
    $conexion = null;
    $sentencia = null;
    header("Location:gest_libros.php");
    exit;
}
///Código para paginación
if (isset($_POST["btnPag"]))
    $_SESSION["pag"] = $_POST["btnPag"];


if (!isset($_SESSION["pag"]))
    $_SESSION["pag"] = 1;


if (isset($_POST["registros"])) {
    $_SESSION["regs_mostrar"] = $_POST["registros"];

    $_SESSION["pag"] = 1;
}


if (!isset($_SESSION["regs_mostrar"]))
    $_SESSION["regs_mostrar"] = 3;



if (!isset($_SESSION["buscar"]))
    $_SESSION["buscar"] = "";


if ($_SESSION["regs_mostrar"] == -1) {
    $n_pags = 1;
} else {
    $ini_pag = ($_SESSION["pag"] - 1) * $_SESSION["regs_mostrar"];
    $consulta = "select * from libros";
    $sentencia = $conexion->prepare($consulta);
    $sentencia->execute();
    $total_registros = $sentencia->rowCount();
    $sentencia = null;
    $n_pags = ceil($total_registros / $_SESSION["regs_mostrar"]);;
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examen3 Curso 23-24</title>
    <style>
        .enlinea {
            display: inline
        }

        .enlace {
            border: none;
            background: none;
            text-decoration: underline;
            color: blue;
            cursor: pointer
        }

        table {
            width: 80%;
            margin: 0 auto;
            text-align: center;
            border-collapse: collapse
        }

        table,
        th,
        td {
            border: 1px solid black
        }

        th {
            background-color: #CCC
        }

        .mensaje {
            font-size: 1.25em;
            color: blue
        }

        label {
            width: 100px;
            float: left
        }

        .error {
            color: red
        }
    </style>
</head>

<body>
    <h1>Librería</h1>
    <div>Bienvenido <strong><?php echo $datos_usuario_log["lector"]; ?></strong> -
        <form class='enlinea' action="gest_libros.php" method="post">
            <button class='enlace' type="submit" name="btnSalir">Salir</button>
        </form>
    </div>
    <form id='form_regs_filtro' class="d_flex" action="gest_libros.php" method='post'>
        <div>
            Mostrar
            <select name='registros'>
                <option <?php if ($_SESSION["regs_mostrar"] == 3)
                            echo "selected"; ?> value='3'>3</option>
                <option <?php if ($_SESSION["regs_mostrar"] == 6)
                            echo "selected"; ?> value='6'>6</option>
                <option <?php if ($_SESSION["regs_mostrar"] == -1)
                            echo "selected"; ?> value='-1'>TODOS</option>
            </select>
            registros por página
        </div>
        <div>
            <button type="submit" name="btnBuscar">Buscar</button>
        </div>
    </form>
    <?php
    if (isset($_SESSION["accion"])) {
        echo "<p class='mensaje'>" . $_SESSION["accion"] . "</p>";
        unset($_SESSION["accion"]);
    }

    echo "<h3>Listado de los libros</h3>";
    try {

        if ($_SESSION["regs_mostrar"] == -1) {

            $consulta = "select * from libros";
        } else {
            $consulta = "select * from libros LIMIT " . $ini_pag . "," . $_SESSION["regs_mostrar"];
        }
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute();
        $libros = $sentencia->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        session_destroy();
        mysqli_close($conexion);
        die("<p>No he podido realizar la consulta: " . $e->getMessage() . "</p></body></html>");
    }

    echo "<table>";
    echo "<tr><th>Ref</th><th>Título</th><th>Acción</th></tr>";
    foreach ($libros as $tupla) {
        echo "<tr>";
        echo "<td>" . $tupla["referencia"] . "</td>";
        echo "<td>" . $tupla["autor"] . "</td>";
        echo "<td><form action='gest_libros.php' method='post'><button class='enlace' name='btnBorrar' value='" . $tupla["referencia"] . "'>Borrar</button> - <button class='enlace' name='btnEditar' value='" . $tupla["referencia"] . "'>Editar</button></form></td>";
        echo "</tr>";
    }
    echo "</table>";
    if ($n_pags > 1) {
        echo "<div class='centrar centrado'>";
        echo "<form action='gest_libros.php' method='post'>";
        echo "<p>";
        if ($_SESSION["pag"] != 1) {
            echo "<button  type='submit' name='btnPag' value='1'>|<</button> ";
            echo "<button  type='submit' name='btnPag' value='" . ($_SESSION["pag"] - 1) . "'><</button> ";
        }

        for ($i = 1; $i <= $n_pags; $i++) {
            if ($_SESSION["pag"] == $i)
                echo "<button disabled type='submit' name='btnPag' value='" . $i . "'>" . $i . "</button> ";
            else
                echo "<button  type='submit' name='btnPag' value='" . $i . "'>" . $i . "</button> ";
        }
        if ($_SESSION["pag"] != $n_pags) {
            echo "<button  type='submit' name='btnPag' value='" . ($_SESSION["pag"] + 1) . "'>></button> ";
            echo "<button  type='submit' name='btnPag' value='" . $n_pags . "'>>|</button> ";
        }

        echo "</p>";
        echo "</form>";
        echo "</div>";
    }

    ?>
    <h3>Agregar un libro nuevo</h3>
    <form action="gest_libros.php" method="post" enctype="multipart/form-data">
        <p>
            <label for="referencia">Referencia:</label>
            <input type="text" name="referencia" id="referencia" value="<?php if (isset($_POST["referencia"]))
                                                                            echo $_POST["referencia"]; ?>">
            <?php
            if (isset($_POST["referencia"]) && $error_referencia) {
                if ($_POST["referencia"] == "")
                    echo "<span class='error'> Campo Vacío</span>";
                elseif (!is_numeric($_POST["referencia"]) || $_POST["referencia"] < 0)
                    echo "<span class='error'> Referencia no es un número mayor o igual que cero</span>";
                else
                    echo "<span class='error'> Referencia repetida</span>";
            }
            ?>
        </p>
        <p>
            <label for="titulo">Título:</label>
            <input type="text" name="titulo" id="titulo" value="<?php if (isset($_POST["titulo"]))
                                                                    echo $_POST["titulo"]; ?>">
            <?php
            if (isset($_POST["titulo"]) && $error_titulo)
                echo "<span class='error'> Campo Vacío</span>";
            ?>
        </p>
        <p>
            <label for="autor">Autor:</label>
            <input type="text" name="autor" id="autor" value="<?php if (isset($_POST["autor"]))
                                                                    echo $_POST["autor"]; ?>">
            <?php
            if (isset($_POST["autor"]) && $error_autor)
                echo "<span class='error'> Campo Vacío</span>";
            ?>
        </p>
        <p>
            <label for="descripcion">Descripción:</label>
            <textarea name="descripcion" id="descripcion"><?php if (isset($_POST["descripcion"]))
                                                                echo $_POST["descripcion"]; ?></textarea>
            <?php
            if (isset($_POST["descripcion"]) && $error_descripcion)
                echo "<span class='error'> Campo Vacío</span>";
            ?>
        </p>
        <p>
            <label for="precio">Precio:</label>
            <input type="text" name="precio" id="precio" value="<?php if (isset($_POST["precio"]))
                                                                    echo $_POST["precio"]; ?>">
            <?php
            if (isset($_POST["precio"]) && $error_precio) {
                if ($_POST["precio"] == "")
                    echo "<span class='error'> Campo Vacío</span>";
                else
                    echo "<span class='error'> El precio debe ser un número mayor que cero</span>";
            }
            ?>
        </p>
        <p>
            <label for="portada">Portada:</label>
            <input type="file" name="portada" id="portada" accept="image/*">
            <?php
            if (isset($_POST["btnAgregar"]) && $error_portada) {
                if ($_FILES["portada"]["error"])
                    echo "<span class='error'>Error en la subida del fichero</span>";
                elseif (!explode(".", $_FILES["portada"]["name"]))
                    echo "<span class='error'>El archivo seleccionado no tiene extensión</span>";
                elseif (!getimagesize($_FILES["portada"]["tmp_name"]))
                    echo "<span class='error'>El archivo seleccionado no es un archivo imagen</span>";
                else
                    echo "<span class='error'>El archivo seleccionado supera los 750KB</span>";
            }

            ?>
        </p>
        <p>
            <button type="submit" name="btnAgregar">Agregar</button>
        </p>
    </form>
</body>

</html>