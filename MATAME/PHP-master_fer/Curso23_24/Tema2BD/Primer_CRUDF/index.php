<?php
require "src/const_funciones.php";

if (isset($_POST["continuarEdit"])) {
    //ERROR NOMBRE
    $error_nombre = $_POST["nombre"] == "" || strlen($_POST["nombre"]) > 30;

        //ERROR CLAVE
        $error_clave=strlen($_POST["clave"]) > 15;

    //ERROR USUARIO
    $error_usuario = $_POST["usuario"] == "" || strlen($_POST["usuario"]) > 20;

    if (!$error_usuario) {

        try {

            $conexion = mysqli_connect("localhost", "jose", "josefa", "bd_foro");
            mysqli_set_charset($conexion, "utf8");

        } catch (Exception $e) {

            //LE PASO LOS 2 PARAMETROS TITLE Y BODY
            die(error_page("Practica 1º CRUD", "<h1>Practica 1º CRUD</h1><p>No ha podido conectarse a la base de datos: " . $e->getMessage() . "</p></body></html>"));
        
        }

        $error_email=repetido_editando($conexion, "usuarios", "email", $_POST["email"],"id_usuario",$_POST["btnEditar"]);
        $error_usuario = repetido_editando($conexion, "usuarios", "usuario", $_POST["usuario"],"id_usuario",$_POST["btnEditar"]);
        if (is_string($error_usuario)) {
            die($error_usuario);
        }

        $error_form= $error_nombre || $error_usuario ||  $error_clave || $error_email; 

        if(!$error_form){


            try {
    
                if($_POST["clave"]==""){

                    $consulta="update usuarios set nombre='".$_POST["nombre"]."', usuario='".$_POST["usuario"]."', email='".$_POST["email"]."' where id_usuario='".$_POST["continuarEdit"]."'";
                }else{

                    $consulta="update usuarios set nombre='".$_POST["nombre"]."', usuario='".$_POST["usuario"]."', clave='".md5($_POST["clave"])."', email='".$_POST["email"]."' where id_usuario='".$_POST["continuarEdit"]."'";
                }

                $consulta="insert into usuarios (nombre,usuario,clave,email) values ('".$_POST["nombre"]."','".$_POST["usuario"]."','".md5($_POST["clave"])."','".$_POST["email"]."')";
                mysqli_query($conexion,$consulta); //COMO ES UN INSERT NO SE RECOGEN EN LA VARIABLE $RESULTADO
                
            } catch (Exception $e) {
        
                mysqli_close($conexion);
                die(error_page("Practica 1º CRUD","<h1>Practica 1º CRUD</h1><p>No ha podido hacer la consulta: ".$e->getMessage()."</p></body></html>"));
            }

            mysqli_close($conexion);

            //inserto en BD y salto a index"
            header("Location:index.php");
            exit;
        }

    }
}

if (isset($_POST["btnContBorrar"])) {

    try {

        $conexion = mysqli_connect("localhost", "jose", "josefa", "bd_foro");
        mysqli_set_charset($conexion, "utf8");
    } catch (Exception $e) {

        die(error_page("Practica 1º CRUD", "<h1>Listado de los usuarios</h1><p>No ha podido hacer la consulta: " . $e->getMessage() . "</p></body></html>"));
    }


    try {

        $consulta = "delete from usuarios where id_usuario='" . $_POST["btnContBorrar"] . "'";
        $resultado = mysqli_query($conexion, $consulta);
    } catch (Exception $e) {

        mysqli_close($conexion);
        die(error_page("Practica 1º CRUD", "<h1>Listado de los usuarios</h1><p>No ha podido hacer la consulta: " . $e->getMessage() . "</p></body></html>"));
    }

    mysqli_close($conexion);
    header("Location:index.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=ç, initial-scale=1.0">
    <title>Practica 1º CRUD</title>
    <style>
        table,
        th,
        td {
            border: 1px solid black;
        }

        table {
            border-collapse: collapse;
            width: 30%;
            text-align: center;
        }

        th {
            background-color: #CCC;
        }

        table img {
            width: 50px;
            height: 50px;
        }

        .enlace {
            border: none;
            background: none;
            cursor: pointer;
            color: blue;
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <h1>Listado de los usuarios</h1>
    <?php

    try {

        $conexion = mysqli_connect("localhost", "jose", "josefa", "bd_foro");
        mysqli_set_charset($conexion, "utf8");
    } catch (Exception $e) {

        die("<p>No ha podido conectarse a la base de datos: " . $e->getMessage() . "</p></body></html>");
    }

    $consulta = "select * from usuarios";


    try {

        $resultado = mysqli_query($conexion, $consulta);
    } catch (Exception $e) {

        mysqli_close($conexion);
        die("<p>Imposible realizar la consulta: " . $e->getMessage() . "</p></body></html>");
    }

    //if(mysqli_num_rows($resultado) > 1){}     Condiciona si la tabla esta vacia o no

    echo "<table>";

    echo "<tr><th>Nombre de usuario</th><th>Borrar</th><th>Editar</th></tr>";
    while ($tupla = mysqli_fetch_assoc($resultado)) {

        echo "<tr>";
        echo "<td><form action='index.php' method='post'><button class='enlace' type='submit' value='" . $tupla["id_usuario"] . "' name='btnDetalle'>" . $tupla["nombre"] . "</button></form></td>";
        echo "<td><form action='index.php' method='post'><input type='hidden' name='nombre_usuario' value='" . $tupla["nombre"] . "'><button type='submit' value='" . $tupla["id_usuario"] . "' name='btnBorrar'><img src='images/x.png' alt='Imagen de Borrar' title='Imagen de Borrar'</button></form></td>";
        echo "<td><form action='index.php' method='post'><input type='hidden' name='nombre_usuario' value='" . $tupla["id_usuario"] . "'><button type='submit' value='" . $tupla["id_usuario"] . "' name='btnEditar'><img src='images/lapiz.png' alt='Imagen de Editar' title='Imagen de Editar'</button></form></td>";
        echo "</tr>";
    }

    echo "</table>";

    //PARA SUSTITUIR EL BOTON SI PULSAS ALGUNO DE LOS NOMBRES Y CONSULTAR LOS DATOS DE UN USUARIO
    if (isset($_POST["btnDetalle"])) {

        echo "<h3> Detalles del usuario con id: " . $_POST["btnDetalle"] . "</h3>";

        try {

            $consulta = "select * from usuarios where id_usuario='" . $_POST["btnDetalle"] . "'";
            $resultado = mysqli_query($conexion, $consulta);
        } catch (Exception $e) {

            mysqli_close($conexion);
            die("<p>No se ha podido realizar la consulta: " . $e->getMessage() . "</p></body></html>");
        }

        //ES BASICAMENTE $tupla con otro nombre
        if (mysqli_num_rows($resultado) > 0) {

            $datos_usuario = mysqli_fetch_assoc($resultado);

            echo "<p>";
            echo "<strong>Nombre: </strong>" . $datos_usuario["nombre"] . "</br>";
            echo "<strong>Usuario: </strong>" . $datos_usuario["usuario"] . "</br>";
            echo "<strong>Email: </strong>" . $datos_usuario["email"] . "</br>";
            echo "</p>";
        } else {

            echo "<p>El usuario selecciona ya no se encuentra registrado en la BD";
        }


        echo "<form action='index.php' method='post'>";
        echo "<p><button type='submit'>Volver</button></p>";
        echo "</form>";
        //BORRADO DEL USUARIO

    } elseif (isset($_POST["btnBorrar"])) {

        require "vistas/vista_conf_borrar.php";


        //EDITAR AL USUARIO
    } elseif (isset($_POST["btnEditar"]) || isset($_POST["continuarEdit"])) {


        if (isset($_POST["btnEditar"])) {
            $id_usuario = $_POST["btnEditar"];
        } else {
            $id_usuario = $_POST["btnEditar"];
        }

        try {

            $consulta = "select * from usuarios where id_usuario='" . $_POST["btnEditar"] . "'";
            $resultado = mysqli_query($conexion, $consulta);
        } catch (Exception $e) {

            mysqli_close($conexion);
            die("<p>No se ha podido realizar la edicion: " . $e->getMessage() . "</p></body></html>");
        }

        if (mysqli_num_rows($resultado) > 0) {


            if (isset($_POST["btnEditar"])) {

                $datos_usuario = mysqli_fetch_assoc($resultado);
                $nombre = $datos_usuario["nombre"];
                $usuario = $datos_usuario["usuario"];
                //$clave=$datos_usuario["clave"];
                $email = $datos_usuario["email"];
            } else {
                $nombre = $_POST["nombre"];
                $usuario = $_POST["usuario"];
                //$clave=$datos_usuario["clave"];
                $email = $_POST["email"];
            }
            mysqli_free_result($resultado);
        } else {
            $mensaje_error_usuario = "<p>El usuario que esta intentando editar ya no existe en la bd</p>";
        }

        if (isset($mensaje_error_usuario)) {
            echo $mensaje_error_usuario;
        }

        $datos_usuario = mysqli_fetch_assoc($resultado);

    ?>

        <h2>Editando el usuario : <?php echo $id_usuario ?></h2>
        <form action="index.php" method="post" enctype="multipart/form-data">
            <p>
                <label for="nombre">Nombre:</label>
                <input type="text" name="nombre" id="nombre" maxlength="30" value="<?php echo $nombre; ?>">

                <?php
                if (isset($_POST["continuarEdit"]) && $error_nombre) {
                    if ($_POST["nombre"] == "") {
                        echo "<span class='error'> Campo vacio</span>";
                    } else {
                        echo "<span class='error'> Has tecleado mas de 30 caracteres</span>";
                    }
                }

                ?>
            </p>


            <p>
                <label for="usuario">Usuario:</label>
                <input type="text" name="usuario" id="usuario" maxlength="20" value="<?php echo $usuario; ?>">

                <?php
                if (isset($_POST["continuarEdit"]) && $error_usuario) {
                    if ($_POST["usuario"] == "") {
                        echo "<span class='error'> Campo vacio</span>";
                    } elseif ($_POST["usuario"] > 20) {
                        echo "<span class='error'> Has tecleado mas de 20 caracteres</span>";
                    } else {
                        echo "<span class='error'>Usuario repetido</span>";
                    }
                }

                ?>
            </p>


            <p>
                <label for="clave">Contraseña:</label>
                <input type="text" name="clave" maxlength="15" id="clave" placeholder="Editar contraseña">
                <?php
                if (isset($_POST["continuarEdit"]) && $error_clave) {
                    if ($_POST["clave"] == "") {
                        echo "<span class='error'> Campo vacio</span>";
                    } else {
                        echo "<span class='error'> Has tecleado mas de 15 caracteres</span>";
                    }
                }

                ?>
            </p>


            <p>
                <label for="email">Email:</label>
                <input type="text" name="email" id="email" maxlength="50" value="<?php echo $email ?>">
                <?php
                if (isset($_POST["continuarEdit"]) && $error_email) {
                    if ($_POST["email"] == "") {
                        echo "<span class='error'> Campo vacio</span>";
                    } elseif (strlen($_POST["email"]) > 50) {

                        echo "<span class='error'> Has tecleado mas de 50 caracteres</span>";
                    } elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {

                        echo "<span class='error'>Email sintaxticamente incorrecto</span>";
                    } else {
                        echo "<span class='error'>Email repetido</span>";
                    }
                }

                ?>
            </p>


            <p>
                <button type="submit" name="continuarEdit" value="<?php echo $id_usuario; ?>">Continuar</button>
                <button type="submit" name="volver">Atras</button>
            </p>

        </form>

    <?php


    } else {
        echo "<form action='usuario_nuevo.php' method='post'>";
        echo "<p><button type='submit' name='btnNuevoUsuario'>Insertar nuevo usuario</button></p>";
        echo "</form>";
    }

    mysqli_free_result($resultado); //LIBERO LA CONSULTA
    mysqli_close($conexion);


    ?>

</body>

</html>