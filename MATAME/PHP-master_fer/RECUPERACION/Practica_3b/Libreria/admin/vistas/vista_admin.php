<?php
if (isset($_POST["btnAgregar"])) {


    $error_referencia_agre = $_POST["referencia_agre"] == "" || !is_numeric($_POST["referencia_agre"]) || $_POST["referencia_agre"] < 0;

    if (!$error_referencia_agre) {
        $respuesta = consumir_servicios_REST(DIR_SERV . "/repetido_insert/libros/referencia/" . $_POST["referencia_agre"], "GET");
        $json = json_decode($respuesta, true);
        if (!$json) {
            session_destroy();
            die(error_page("Práctica Rec 3B", "<h1>Práctica Rec 3B</h1><p>Sin respuesta oportuna de la API</p>"));
        }

        if (isset($json["error_bd"])) {
            session_destroy();
            consumir_servicios_REST(DIR_SERV . "/salir", "POST", $datos_env);
            die(error_page("Práctica Rec 3B", "<h1>Práctica Rec 3B</h1><p>" . $json["error_bd"] . "</p>"));
        }
        $error_referencia_agre = $json["repetido"];
    }


    $error_titulo_agre = $_POST["titulo_agre"] == "";
    $error_autor_agre = $_POST["autor_agre"] == "";
    $error_descripcion_agre = $_POST["descripcion_agre"] == "";
    $error_precio_agre = $_POST["precio_agre"] == "" || !is_numeric($_POST["precio_agre"]) || $_POST["precio_agre"] <= 0;
    $array_nombre = explode(".", $_FILES["portada_agre"]["name"]);
    $error_portada_agre = $_FILES["portada_agre"]["name"] != "" && ($_FILES["portada_agre"]["error"] || !$array_nombre || !getimagesize($_FILES["portada_agre"]["tmp_name"]) || $_FILES["portada_agre"]["size"] > 750 * 1024);
    $error_form_agre = $error_referencia_agre || $error_titulo_agre || $error_autor_agre || $error_descripcion_agre || $error_precio_agre || $error_portada_agre;
    if (!$error_form_agre) {

        $datos_env_insert["referencia"] = $_POST["referencia_agre"];
        $datos_env_insert["titulo"] = $_POST["titulo_agre"];
        $datos_env_insert["autor"] = $_POST["autor_agre"];
        $datos_env_insert["descripcion"] = $_POST["descripcion_agre"];
        $datos_env_insert["precio"] = $_POST["precio_agre"];
        $datos_env_insert["foto"] = $_FILES["portada_agre"];

        $respuesta = consumir_servicios_REST(DIR_SERV . "/insertar_libro", "POST", $datos_env_insert);
        $json = json_decode($respuesta, true);
        if (!$json) {
            session_destroy();
            die(error_page("Práctica Rec 3B", "<h1>Práctica Rec 3B</h1><p>Sin respuesta oportuna de la API</p>"));
        }

        if (isset($json["error_bd"])) {
            session_destroy();
            consumir_servicios_REST(DIR_SERV . "/salir", "POST", $datos_env);
            die(error_page("Práctica Rec 3B", "<h1>Práctica Rec 3</h1><p>" . $json["error_bd"] . "</p>"));
        }



        $_SESSION["accion"] = "Libro agregado con éxito";
        // realizo la inserccion de la foto
        if ($_FILES["portada_agre"]["name"] != "") {

            $ultm_refe = $_POST["referencia_agre"];

            $array_ext = explode(".", $_FILES["portada_agre"]["name"]);
            $ext = "." . end($array_ext);
            $nombre_nuevo = "img_" . $ultm_refe . $ext;
            @$var = move_uploaded_file($_FILES["portada_agre"]["tmp_name"], "../images/" . $nombre_nuevo);


            if ($var) {

                $datos_env_act["portada"] = $nombre_nuevo;
                $datos_env_act["referencia"] = $ultm_refe;
                $respuesta = consumir_servicios_REST(DIR_SERV . "/actualizar_foto", "PUT", $datos_env_act);
                $json = json_decode($respuesta, true);
                if (!$json) {
                    session_destroy();
                    die(error_page("Práctica Rec 3", "<h1>Práctica Rec 3</h1><p>Sin respuesta oportuna de la API</p>"));
                }

                if (isset($json["error_bd"])) {
                    if (file_exists("../images/" . $nombre_nuevo))
                        unlink("../images/" . $nombre_nuevo);

                    $mensaje = "Usuario insertado con éxito pero con la imagen por defecto por un problema en la BD del servidor";
                }
            } else {
                $mensaje = "Usuario insertado con éxito pero con la imagen por defecto ya que no se ha podido mover la imagen a la carpeta destino en el servidor";
            }
        }
    }
}
if (isset($_POST["btnBorrar"])) {


    $respuesta = consumir_servicios_REST(DIR_SERV . "/borrar_libro/" . $_POST["btnBorrar"], "DELETE", $datos_env);
    $json = json_decode($respuesta, true);
    if (!$json) {
        session_destroy();
        die(error_page("Práctica Rec 3B", "<h1>Práctica Rec 3B</h1><p>Sin respuesta oportuna de la API</p>"));
    }

    if (isset($json["error_bd"])) {

        session_destroy();
        consumir_servicios_REST(DIR_SERV . "/salir", "POST", $datos_env);
        die(error_page("Práctica Rec 3B", "<h1>Práctica Rec 3B</h1><p>" . $json["error_bd"] . "</p>"));
    }

    if (isset($json["no_auth"])) {
        session_unset();
        $_SESSION["seguridad"] = "Usted ha dejado de tener acceso a la API. Por favor vuelva a loguearse.";
        header("Location:index.php");
        exit();
    }

    if ($_POST["portada_agre"] != FOTO_DEFECTO && file_exists("../images/" . $_POST["portada_agre"]))
        unlink("../images/" . $_POST["portada_agre"]);


    $_SESSION["accion"] = "El libro ha sido borrado con exito";
    $_SESSION["pag"] = 1; //Al poner paginación cuándo borro siempre me voy página
    header("Location:gest_libros.php");
    exit;
}
// si le doy a editar me traigo al libro con su referencia
if (isset($_POST["btnEditar"]) || isset($_POST["btnConEditar"])) {

    $respuesta = consumir_servicios_REST(DIR_SERV . "/obtener_detalles/" . $_POST["btnEditar"], "GET", $datos_env);
    $json = json_decode($respuesta, true);
    if (!$json) {
        session_destroy();
        die(error_page("Práctica Rec 3B", "<h1>Práctica Rec 3B</h1><p>Sin respuesta oportuna de la API</p>"));
    }

    if (isset($json["error_bd"])) {

        session_destroy();
        consumir_servicios_REST(DIR_SERV . "/salir", "POST", $datos_env);
        die(error_page("Práctica Rec 3B", "<h1>Práctica Rec 3B</h1><p>" . $json["error_bd"] . "</p>"));
    }

    if (isset($json["no_auth"])) {
        session_unset();
        $_SESSION["seguridad"] = "Usted ha dejado de tener acceso a la API. Por favor vuelva a loguearse.";
        header("Location:index.php");
        exit();
    }

    $datos_libro = $json["libro"];

    if ($datos_libro) {

        $referencia = $datos_libro["referencia"];
        $titulo = $datos_libro["titulo"];
        $autor = $datos_libro["autor"];
        $descripcion = $datos_libro["descripcion"];
        $precio = $datos_libro["precio"];
        $foto = $datos_libro["portada"];
    }
}
// control de errores del continuar EDITAR !!!!!!!
if (isset($_POST["btnContEditar"])) {
    //$referenciaBD=$_POST["referenciaBD"];

    $referencia = $_POST["referencia"];
    $titulo = $_POST["titulo"];
    $autor = $_POST["autor"];
    $descripcion = $_POST["descripcion"];
    $precio = $_POST["precio"];



    $error_referencia = $_POST["referencia"] == "" || !is_numeric($_POST["referencia"]) || $_POST["referencia"] < 0;
    if (!$error_referencia) {
        // $error_referencia = repetido($conexion, "libros", "referencia", $_POST["referencia"]);
        if (is_string($error_referencia)) {
            session_destroy();
            $conexion = null;
            die(error_page("Práctica Rec 3B", "<h1>Librería Práctica Rec 3B</h1><p>Error en la consulta: " . $error_referencia . "</p>"));
        }
    }
    $error_titulo = $_POST["titulo"] == "";
    $error_autor = $_POST["autor"] == "";
    $error_descripcion = $_POST["descripcion"] == "";
    $error_precio = $_POST["precio"] == "" || !is_numeric($_POST["precio"]) || $_POST["precio"] <= 0;
    $array_nombre = explode(".", $_FILES["portada"]["name"]);
    $error_portada = $_FILES["portada"]["name"] != "" && ($_FILES["portada"]["error"] || !$array_nombre || !getimagesize($_FILES["portada"]["tmp_name"]) || $_FILES["portada"]["size"] > 750 * 1024);
    $error_form = $error_referencia || $error_titulo || $error_autor || $error_descripcion || $error_precio || $error_portada;

    //si paso el control de errores de Editar
    if (!$error_form && isset($_POST["btnContEditar"])) {

        //ojo necesitamos recoger los dartos de los imputs  para enviarlos al metodo
        $datos_env["titulo"] = $titulo;
        $datos_env["autor"] = $autor;
        $datos_env["descripcion"] = $descripcion;
        $datos_env["precio"] = $precio;

        $respuesta = consumir_servicios_REST(DIR_SERV . "/actualizar_libro/" . $referencia, "PUT", $datos_env);
        $json = json_decode($respuesta, true);
        if (!$json) {
            session_destroy();
            die(error_page("Práctica Rec 3B", "<h1>Práctica Rec 3B</h1><p>Sin respuesta oportuna de la API</p>"));
        }

        if (isset($json["error_bd"])) {
            session_destroy();
            consumir_servicios_REST(DIR_SERV . "/salir", "POST", $datos_env);
            die(error_page("Práctica Rec 3B", "<h1>Práctica Rec 3B</h1><p>" . $json["error_bd"] . "</p>"));
        }

        if (isset($json["no_auth"])) {
            session_unset();
            $_SESSION["seguridad"] = "Usted ha dejado de tener acceso a la API. Por favor vuelva a loguearse.";
            header("Location:index.php");
            exit();
        }

        $mensaje = "Usuario editado con éxito";


        if ($_FILES["portada"]["name"] != "") {

            $ultm_refe = $_POST["referencia"];

            $array_ext = explode(".", $_FILES["portada"]["name"]);
            $ext = "." . end($array_ext);
            $nombre_nuevo = "img_" . $ultm_refe . $ext;
            @$var = move_uploaded_file($_FILES["portada"]["tmp_name"], "../images/" . $nombre_nuevo);

            var_dump($var);
            if ($var) {

                $datos_env_act["portada"] = $nombre_nuevo;
                $datos_env_act["referencia"] = $ultm_refe;
                $respuesta = consumir_servicios_REST(DIR_SERV . "/actualizar_foto", "PUT", $datos_env_act);
                $json = json_decode($respuesta, true);
                if (!$json) {
                    session_destroy();
                    die(error_page("Práctica Rec 3", "<h1>Práctica Rec 3</h1><p>Sin respuesta oportuna de la API</p>"));
                }

                if (isset($json["error_bd"])) {
                    if (file_exists("../images/" . $nombre_nuevo))
                        unlink("../images/" . $nombre_nuevo);

                    $mensaje = "Usuario insertado con éxito pero con la imagen por defecto por un problema en la BD del servidor";
                }
            } else {
                $mensaje = "Usuario insertado con éxito pero con la imagen por defecto ya que no se ha podido mover la imagen a la carpeta destino en el servidor";
            }
        }
        //********************************************* */

        $mensaje = "Usuario editado con éxito";

        $_SESSION["accion"] = $mensaje;
        header("Location:gest_libros.php");
        exit();
    }
}


// detalle del libro
if (isset($_POST["btnDetalle"])) {

    $respuesta = consumir_servicios_REST(DIR_SERV . "/obtener_detalles/" . $_POST["btnDetalle"], "GET", $datos_env);
    $json = json_decode($respuesta, true);
    if (!$json) {
        session_destroy();
        die(error_page("Práctica Rec 3B", "<h1>Práctica Rec 3B</h1><p>Sin respuesta oportuna de la API</p>"));
    }

    if (isset($json["error_bd"])) {

        session_destroy();
        consumir_servicios_REST(DIR_SERV . "/salir", "POST", $datos_env);
        die(error_page("Práctica Rec 3B", "<h1>Práctica Rec 3B</h1><p>" . $json["error_bd"] . "</p>"));
    }

    if (isset($json["no_auth"])) {
        session_unset();
        $_SESSION["seguridad"] = "Usted ha dejado de tener acceso a la API. Por favor vuelva a loguearse.";
        header("Location:index.php");
        exit();
    }

    $detalle_libro = $json["libro"];
}
/*Aqui la gestion de paginación*/
if (isset($_POST["btnPag"]))
    $_SESSION["pag"] = $_POST["btnPag"];


if (!isset($_SESSION["pag"]))
    $_SESSION["pag"] = 1;

if (isset($_POST["registros"])) {
    $_SESSION["regs_mostrar"] = $_POST["registros"];
    $_SESSION["buscar"] = $_POST["buscar"];
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



    if ($_SESSION["buscar"] == "") {
        $respuesta = consumir_servicios_REST(DIR_SERV . "/obtener_libros", "GET", $datos_env);
    } else {
        $datos_env["buscar"] = $_SESSION["buscar"];
        $respuesta = consumir_servicios_REST(DIR_SERV . "/obtener_libros_filtro", "GET", $datos_env);
    }
    $json = json_decode($respuesta, true);
    if (!$json) {
        session_destroy();
        die(error_page("Práctica Rec 3B", "<h1>Práctica Rec 3B</h1><p>Sin respuesta oportuna de la API</p>"));
    }

    if (isset($json["error_bd"])) {

        session_destroy();
        consumir_servicios_REST(DIR_SERV . "/salir", "POST", $datos_env);
        die(error_page("Práctica Rec 3B", "<h1>Práctica Rec 3B</h1><p>" . $json["error_bd"] . "</p>"));
    }

    if (isset($json["no_auth"])) {
        session_unset();
        $_SESSION["seguridad"] = "Usted ha dejado de tener acceso a la API. Por favor vuelva a loguearse.";
        header("Location:index.php");
        exit();
    }

    $total_registros = count($json["libros"]);
    $n_pags = ceil($total_registros / $_SESSION["regs_mostrar"]);
}
/*****consulta para mostra la tabla******/



if ($_SESSION["buscar"] == "") {

    if ($_SESSION["regs_mostrar"] == -1)
        $respuesta = consumir_servicios_REST(DIR_SERV . "/obtener_libros", "GET", $datos_env);
    else
        $respuesta = consumir_servicios_REST(DIR_SERV . "/obtener_libros_pag/" . $ini_pag . "/" . $_SESSION["regs_mostrar"], "GET", $datos_env);
} else {
    if ($_SESSION["regs_mostrar"] == -1)
        $respuesta = consumir_servicios_REST(DIR_SERV . "/obtener_libros_filtro", "GET", $datos_env);
    else
        $respuesta = consumir_servicios_REST(DIR_SERV . "/obtener_libros_filtro_pag/" . $ini_pag . "/" . $_SESSION["regs_mostrar"], "GET", $datos_env);
}


$json = json_decode($respuesta, true);
if (!$json) {
    session_destroy();
    die(error_page("Práctica Rec 3B", "<h1>Práctica Rec 3</h1><p>Sin respuesta oportuna de la API</p>"));
}

if (isset($json["error_bd"])) {

    session_destroy();
    consumir_servicios_REST(DIR_SERV . "/salir", "POST", $datos_env);
    die(error_page("Práctica Rec 3B", "<h1>Práctica Rec 3</h1><p>" . $json["error_bd"] . "</p>"));
}

if (isset($json["no_auth"])) {
    session_unset();
    $_SESSION["seguridad"] = "Usted ha dejado de tener acceso a la API. Por favor vuelva a loguearse.";
    header("Location:index.php");
    exit();
}
$libros = $json["libros"];





?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
            width: 40%;
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

        .d_flex {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.5em
        }



        .list_libros {
            border: 1px solid black;
            margin: 0.5rem;
            flex: 0 25%;
        }

        body {
            display: flex;
            flex-direction: column;
            flex-wrap: wrap;
        }

        .segundo {
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
        }

        .h1segundo {
            flex: 1 100%;
        }

        .buscador {
            flex: 1 100%;
        }

        .contenedor {
            flex: 1 100%;
        }

        .botones {
            flex: 1 100%;
        }
    </style>
</head>

<body>

    <div class="primero">
        Bienvenido <strong><?php echo $datos_usuario_log["lector"]; ?></strong> -
        <form class="en_linea" action="../index.php" method="post">
            <button class="enlace" name="btnSalir" type="submit">Salir</button>
        </form>
    </div>
    <?php
    /*********************************************EDITAR************************************************/
    if (isset($_POST["btnEditar"]) || isset($_POST["btnContEditar"])) {
    ?>
        <div class="tercero">
            <h3>Formulario Editar</h3>
            <form action="gest_libros.php" method="post" enctype="multipart/form-data">
                <p>
                    <label for="referencia">Referencia:</label>
                    <input type="text" name="referencia" id="referencia" value="<?php echo $referencia; ?>">
                    <?php
                    if (isset($_POST["btnContEditar"])) {
                        if (isset($_POST["referencia"]) && $error_referencia) {
                            if ($_POST["referencia"] == "")
                                echo "<span class='error'> Campo Vacío</span>";
                            elseif (!is_numeric($_POST["referencia"]) || $_POST["referencia"] < 0)
                                echo "<span class='error'> Referencia no es un número mayor o igual que cero</span>";
                            else
                                echo "<span class='error'> Referencia repetida</span>";
                        }
                    }

                    ?>
                </p>
                <p>
                    <label for="titulo">Título:</label>
                    <input type="text" name="titulo" id="titulo" value="<?php echo $titulo; ?>">
                    <?php
                    if (isset($_POST["btnContEditar"])) {
                        if (isset($_POST["titulo"]) && $error_titulo)
                            echo "<span class='error'> Campo Vacío</span>";
                    }

                    ?>
                </p>
                <p>
                    <label for="autor">Autor:</label>
                    <input type="text" name="autor" id="autor" value="<?php echo $autor; ?>">
                    <?php
                    if (isset($_POST["btnContEditar"])) {
                        if (isset($_POST["autor"]) && $error_autor)
                            echo "<span class='error'> Campo Vacío</span>";
                    }

                    ?>
                </p>
                <p>
                    <label for="descripcion">Descripción:</label>
                    <textarea name="descripcion" id="descripcion"><?php echo $descripcion; ?></textarea>
                    <?php
                    if (isset($_POST["btnContEditar"])) {
                        if (isset($_POST["descripcion"]) && $error_descripcion)
                            echo "<span class='error'> Campo Vacío</span>";
                    }

                    ?>
                </p>
                <p>
                    <label for="precio">Precio:</label>
                    <input type="text" name="precio" id="precio" value="<?php echo $precio; ?>">
                    <?php
                    if (isset($_POST["btnContEditar"])) {
                        if (isset($_POST["precio"]) && $error_precio) {
                            if ($_POST["precio"] == "")
                                echo "<span class='error'> Campo Vacío</span>";
                            else
                                echo "<span class='error'> El precio debe ser un número mayor que cero</span>";
                        }
                    }

                    ?>
                </p>
                <p>
                    <label for="portada">Portada:</label>
                    <input type="file" name="portada" id="portada" accept="image/*">
                    <?php
                    if (isset($_POST["btnContEditar"])) {
                        if (isset($_POST["btnContEditar"]) && $error_portada) {
                            if ($_FILES["portada"]["error"])
                                echo "<span class='error'>Error en la subida del fichero</span>";
                            elseif (!explode(".", $_FILES["portada"]["name"]))
                                echo "<span class='error'>El archivo seleccionado no tiene extensión</span>";
                            elseif (!getimagesize($_FILES["portada"]["tmp_name"]))
                                echo "<span class='error'>El archivo seleccionado no es un archivo imagen</span>";
                            else
                                echo "<span class='error'>El archivo seleccionado supera los 750KB</span>";
                        }
                    }

                    ?>
                </p>
                <p>
                    <input type="hidden" name="foto_bd" value='<?php echo $foto; ?>'>
                    <input type="hidden" name="referenciaBD" value="<?php $referencia; ?>"></input>
                    <button type="submit" name="btnContEditar" value="<?php $referencia; ?>">Editar Libro</button>
                </p>
            </form>
        <?php
    }
        ?>
        <?php
        if (isset($_POST["btnDetalle"])) {

            //aqui muestro el detalle del libro 

            echo "<div class='centrar centrado'>";
            echo "<h3>Detalles del Libro  con referencia: " . $_POST["btnDetalle"] . "</h3>";
            if ($detalle_libro) {
                echo "<p><strong>Referencia: </strong>" . $detalle_libro["referencia"] . "</p>";
                echo "<p><strong>Título: </strong>" . $detalle_libro["titulo"] . "</p>";
                echo "<p><strong>Autor: </strong>" . $detalle_libro["autor"] . "</p>";
                echo "<p><strong>Descripcion: </strong>" . $detalle_libro["descripcion"] . "</p>";
                echo "<p><strong>Precio: </strong>" . $detalle_libro["precio"] . "</p>";
                echo "<p><strong>Foto: </strong><img class='reducida' src='../images/" . $detalle_libro["portada"] . "' alt='Foto' title='Foto'/></p>";
            } else
                echo "<p>El usuario seleccionado ya no se encuentra en la BD</p>";
            echo "</div>";
        }


        if (isset($_SESSION["accion"])) {
            echo "<p class='mensaje'>" . $_SESSION["accion"] . "</p>";
            unset($_SESSION["accion"]);
        }
        ?>

        <div class="segundo">
            <h1 class="h1segundo">Listado de los Libros</h1>
            <div class='buscador'>
                <form id='form_regs_filtro' class="d_flex" action='gest_libros.php' method='post'>
                    <div>
                        Mostrar
                        <select name='registros' onchange='document.getElementById("form_regs_filtro").submit();'>
                            <option <?php if ($_SESSION["regs_mostrar"] == 3) echo "selected"; ?> value='3'>3</option>
                            <option <?php if ($_SESSION["regs_mostrar"] == 6) echo "selected"; ?> value='6'>6</option>
                            <option <?php if ($_SESSION["regs_mostrar"] == -1) echo "selected"; ?> value='-1'>TODOS</option>
                        </select>
                        registros por página
                    </div>
                    <div>
                        <input type="text" name="buscar" value="<?php echo $_SESSION["buscar"]; ?>"><button type="submit" name="btnBuscar">Buscar</button>
                    </div>
            </div>
            <?php
            echo "<table class='contenedor'>";
            echo "<tr><th>Ref</th><th>Título</th><th>Acción</th></tr>";
            foreach ($libros as $tupla) {
                echo "<tr>";
                echo "<td>" . $tupla["referencia"] . "</td>";
                echo "<td><form action='gest_libros.php' method='post'><button class='enlace' type='submit' value='" . $tupla["referencia"] . "' name='btnDetalle'>" . $tupla["titulo"] . "</button>";
                echo "<td><form action='gest_libros.php' method='post'><button class='enlace' type='submit' value='" . $tupla["referencia"] . "' name='btnBorrar'>Borrar</button>-<button class='enlace' name='btnEditar' value='" . $tupla["referencia"] . "'>Editar</button></form></td>";
                echo "</tr>";
            }
            echo "</table>";
            if ($n_pags > 1) {
                echo "<div class='botones'>";
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

        </div>


        <div class="tercero">
            <h3>Agregar un libro nuevo</h3>
            <form action="gest_libros.php" method="post" enctype="multipart/form-data">
                <p>
                    <label for="referencia_agre">Referencia:</label>
                    <input type="text" name="referencia_agre" id="referencia_agre" value="<?php if (isset($_POST["referencia_agre"])) echo $_POST["referencia_agre"]; ?>">
                    <?php
                    if (isset($_POST["referencia_agre"]) && $error_referencia_agre) {
                        if ($_POST["referencia_agre"] == "")
                            echo "<span class='error'> Campo Vacío</span>";
                        elseif (!is_numeric($_POST["referencia_agre"]) || $_POST["referencia_agre"] < 0)
                            echo "<span class='error'> Referencia no es un número mayor o igual que cero</span>";
                        else
                            echo "<span class='error'> Referencia repetida</span>";
                    }
                    ?>
                </p>
                <p>
                    <label for="titulo_agre">Título:</label>
                    <input type="text" name="titulo_agre" id="titulo_agre" value="<?php if (isset($_POST["titulo_agre"])) echo $_POST["titulo_agre"]; ?>">
                    <?php
                    if (isset($_POST["titulo_agre"]) && $error_titulo_agre)
                        echo "<span class='error'> Campo Vacío</span>";
                    ?>
                </p>
                <p>
                    <label for="autor_agre">Autor:</label>
                    <input type="text" name="autor_agre" id="autor_agre" value="<?php if (isset($_POST["autor_agre"])) echo $_POST["autor_agre"]; ?>">
                    <?php
                    if (isset($_POST["autor_agre"]) && $error_autor_agre)
                        echo "<span class='error'> Campo Vacío</span>";
                    ?>
                </p>
                <p>
                    <label for="descripcion_agre">Descripción:</label>
                    <textarea name="descripcion_agre" id="descripcion_agre"><?php if (isset($_POST["descripcion_agre"])) echo $_POST["descripcion_agre"]; ?></textarea>
                    <?php
                    if (isset($_POST["descripcion_agre"]) && $error_descripcion_agre)
                        echo "<span class='error'> Campo Vacío</span>";
                    ?>
                </p>
                <p>
                    <label for="precio_agre">Precio:</label>
                    <input type="text" name="precio_agre" id="precio_agre" value="<?php if (isset($_POST["precio_agre"])) echo $_POST["precio_agre"]; ?>">
                    <?php
                    if (isset($_POST["precio_agre"]) && $error_precio_agre) {
                        if ($_POST["precio_agre"] == "")
                            echo "<span class='error'> Campo Vacío</span>";
                        else
                            echo "<span class='error'> El precio debe ser un número mayor que cero</span>";
                    }
                    ?>
                </p>
                <p>
                    <label for="portada_agre">Portada:</label>
                    <input type="file" name="portada_agre" id="portada_agre" accept="image/*">
                    <?php
                    if (isset($_POST["btnAgregar"]) && $error_portada_agre) {
                        if ($_FILES["portada_agre"]["error"])
                            echo "<span class='error'>Error en la subida del fichero</span>";
                        elseif (!explode(".", $_FILES["portada_agre"]["name"]))
                            echo "<span class='error'>El archivo seleccionado no tiene extensión</span>";
                        elseif (!getimagesize($_FILES["portada_agre"]["tmp_name"]))
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