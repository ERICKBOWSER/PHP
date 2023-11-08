<?php

    require "src/constantes_funciones.php";

    if(isset($_POST["btnContinuarBorrar"])){

        try{
            $conexion = mysqli_connect("localhost", "jose", "josefa", "bd_foro");

            mysqli_set_charset($conexion, "utf8"); // Establecer el lector

        } catch(Exception $e){
            // NUNCA PUEDE IR UN mysqli_close() PORQUE NO SE HA HECHO NI LA CONEXIÓN DE LA BBDD
            die(errorPage("<h1>Practica 1º CRUD</h1>", "<h1>Listado de los usuarios</h1><p>No ha podido conectarse a la BBDD: " . $e->getMessage() . "</p></body></html>"));
        } 

        try{
            $consulta = "DELETE FROM usuarios WHERE idUsuario='" . $_POST["btnContinuarBorrar"] . "'";
            mysqli_query($conexion, $consulta);

        } catch(Exception $e){

            mysqli_close($conexion)
            // NUNCA PUEDE IR UN mysqli_close() PORQUE NO SE HA HECHO NI LA CONEXIÓN DE LA BBDD
            die(errorPage("Practica 1º CRUD", "<h1>Listado de los usuarios</h1><p>No ha podido conectarse a la BBDD: " . $e->getMessage() . "</p></body></html>"));
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD</title>
    <style>
        table, td, th{border: 1px solid black}
        table{border-collapse:collapse; text-align: center}
        th{background-color: #ccc}
        table img{width:50px}
        .enlace{border:none;background:none;cursor:pointer;color:blue;text-decoration:underline}  
    </style>
</head>
<body>
    <h1>Listado de todos los usuarios</h1>

    <?php
    if(!isset($conexion)){
        try{
            $conexion = mysqli_connect("localhost", "jose", "josefa", "bd_foro");

            mysqli_set_charset($conexion, "utf8"); // Establecer el lector

        } catch(Exception $e){
            // NUNCA PUEDE IR UN mysqli_close() PORQUE NO SE HA HECHO NI LA CONEXIÓN DE LA BBDD
            die("<p>No ha podido conectarse a la BBDD: " . $e->getMessage() . "</p></body></html>");
        }        
    }
        try{
            $consulta = "SELECT * FROM usuarios"; //PUEDE IR FUERA

            $resultado = mysqli_query($conexion, $consulta);



        } catch(Exception $e){
            die("<p>No se ha podido realizar la consulta: " . $e->getMessage() . "</p>");

            mysqli_close($conexion); // SI FALLA LA CONSULTA HAY QUE CERRAR LA CONEXIÓN OBLIGATORIAMENTE
        }

        //if(mysqli_num_rows($resultado) > 1){ // Si hay más de 1 fila 
            echo "<table>";
            echo "<tr><th>Nombre de Usuario</th><th>Borrar</th><th>Editar</th></tr>";
    
            while($tupla = mysqli_fetch_assoc($resultado)){
                echo "<tr>";
                echo "<td><form action='index.php' method='post'><button class='enlace' type='submit' value='".$tupla["id_usuario"]."' name='btnDetalle' title='Detalles del Usuario'>".$tupla["nombre"]."</button></form></td>";
                echo "<td><form action='index.php' method='post'><input type='hidden' name='nombre_usuario' value='".$tupla["nombre"]."'><button class='enlace' type='submit' value='".$tupla["id_usuario"]."' name='btnBorrar'><img src='images/borrar.png' alt='Imagen de Borrar' title='Borrar Usuario'></button></form></td>";
                echo "<td><form action='index.php' method='post'><button class='enlace' type='submit' value='".$tupla["id_usuario"]."' name='btnEditar'><img src='images/editar.png' alt='Imagen de Editar' title='Editar Usuario'></button></form></td>";
                echo "</tr>";
            }

            echo "</table>";
        //}

        // CUANDO SE HACE CONSULTAS MUY LARGAS SE COLOCA PARA LIBERAR CACHÉ
        mysqli_free_result($resultado);

        if(isset($_POST["btnDetalle"])){
            echo "<h3>Detalles del usuario con id: " . $_POST["btnDetalle"] . "</h3>";
            try{
                $consulta = "SELECT * FROM usuarios WHERE id_usuario='" . $_POST["btnDetalle"] . "'";
                $resultado = mysqli_query($conexion, $consulta);
            }catch(Exception $e){
                mysqli_close($conexion);
                die("<p>No se ha podido realizar la consulta: " . $e->getMessage() . "</p></body></html>");
            }

            if(mysqli_num_rows($resultado) > 0){
                $datosUsuario = mysqli_fetch_assoc($resultado);
                mysqli_free_result($resultado);

                echo "<p>";
                echo "<strong>Nombre: </strong>" . $datosUsuario["nombre"] . "<br/>";
                echo "<strong>Usuario: </strong>" . $datosUsuario["usuario"] . "<br/>";
                echo "<strong>Email: </strong>" . $datosUsuario["email"] . "<br/>";
            }else{
                echo "<p>El usuario seleccionado ya no se encuentra registrado en la BD</p>";
            }

            echo "<form action='index.php' method='post'>";
            echo "<p><button type='submit'>Volver</button></p>";
            echo "</form>";

        }elseif(isset($_POST["btnBorrar"])){
            echo "<p>Se dispone usted a borrar a usuario <strong>" . $_POST["nombreUsuario"] . "</strong></p>";
            echo "<form action='index.php' method='post'>";
            echo "<p><button type='submit' name='btnContBorrar' value='" . $_POST["btnBorrar"] . "'>Continuar</button>";
            echo "<button type='submit'>Atrás</button></p>";
            echo "</form>";
        }else{
            echo "<form action='usuarioNuevo.php' method='post'>";
            echo "<p><button type='submit' name='btnNuevoUsuario'>Insertar nuevo Usuario</button></p>"
            echo "</form>";
        }

        // CERRAR CONEXIÓN
        mysqli_close($conexion);

    ?>
</body>
</html>