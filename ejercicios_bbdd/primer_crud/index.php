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
    </style>
</head>
<body>
    <h1>Listado de todos los usuarios</h1>

    <?php
        try{
            $conexion = mysqli_connect("localhost", "jose", "josefa", "bd_foro");

            mysqli_set_charset($conexion, "utf8"); // Establecer el lector

        } catch(Exception $e){
            // NUNCA PUEDE IR UN mysqli_close() PORQUE NO SE HA HECHO NI LA CONEXIÓN DE LA BBDD
            die("<p>No ha podido conectarse a la BBDD: " . $e->getMessage() . "</p></body></html>");
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
                echo "<td>" . $tupla["nombre"] . "</td>";
                echo "<td><img src='images/borrar.png' alt='Imagen de borrar' title='Imagen de borrar'></td>";
                echo "<td><img src='images/editar.png' alt='Imagen de editar' title='Imagen de editar'></td>";
                echo "</tr>";
            }

            echo "</table>";

            echo "<form action='usuario_nuevo.php' method='post'>";
            echo "<p><button type='submit' name='btnNuevoUsuario'>Nuevo Usuario</button></p>";
            echo "</form>";

        //}

        // CUANDO SE HACE CONSULTAS MUY LARGAS SE COLOCA PARA LIBERAR CACHÉ
        mysqli_free_result($resultado);

        // CERRAR CONEXIÓN
        mysqli_close($conexion);

    ?>
</body>
</html>