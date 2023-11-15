<?php
        if(!isset($conexion)){
            try{
                $conexion = mysqli_connect("localhost", "jose", "josefa", "bd_cv");
                mysqli_set_charset($conexion, "utf8");
            }catch(Exception $e){
                die("<p>No ha podido conectarse a la base de datos: " . $e->getMessage(). "</p></body></html>");
            }
        }

        try{
            $consulta = "SELECT * FROM usuarios";
            $resultado = mysqli_query($conexion, $consulta);
        }catch(Exception $e){
            mysqli_close($conexion);
            die("<p>No se ha podido realizar la consulta: ".$e->getMessage()."</p></body></html>");
        }

        echo "<table>";
        echo "<tr><th>#</th><th>Foto</th><th>Nombre</th></tr>";
        while($tupla = mysqli_fetch_assoc($resultado)){
            echo "<tr>";
            echo "<td><form action='index.php' method='post'><button class='enlace' type='submit' value='" . $tupla["id_usuario"] . "' name='btnID' title='ID del usuario'>" . $tupla["id_usuario"] . "</button></form></td>";
            echo "<td><form action='index.php' method='post'><button class='enlace' type='submit' value='" . $tupla["foto"] . "' name='btnFoto' title='Foto del usuario'>" . $tupla["foto"] . "<button></form></td>";
            echo "<td><form action='index.php' method='post'><input class='enlace' type='submit' value='" . $tupla["nombre"] . "' name='btnNombre' title='Nombre del usuario'/></form></td>";
            echo "</tr>";
        }
        echo "</table>";

        mysqli_free_result($resultado);

    ?>