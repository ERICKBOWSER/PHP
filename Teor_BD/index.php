<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teoría BD</title>
    <style>
        table, th, td {border:1px solid black}
        table{border-collapse: collapse; width: 80%; margin: 0 auto; text-align:center}
        th{background-color: #ccc}
    </style>
</head>
<body>
    <h1>Teoría BBDD</h1>
    <?php
        try{
            $conexion = mysqli_connect("localhost", "jose", "josefa", "bd_teoria");

            mysqli_set_charset($conexion, "utf8"); // Establecer el lector

        } catch(Exception $e){
            die("<p>No ha podido conectarse a la BBDD: " . $e->getMessage() . "</p>");
        }
        
        try{
            $consulta = "SELECT * FROM t_alumnos";
            $resultado = mysqli_query($conexion, $consulta);

        }catch(Exception $e){

            mysqli_close($conexion); // IMPORTANTE cerrar conexión si falla
            die("<p>Imposible realizar la consulta: " . $e->getMessage() . "</p></body></html>");
        }

        $n_tuplas = mysqli_num_rows($resultado); // Conseguimos el número de tuplas que hay en esa tabla

        echo "<p>El número de tuplas obtenidas ha sido: " . $n_tuplas . ".</p>";

        $tupla = mysqli_fetch_assoc($resultado); // Obtener los datos de la bbdd

        echo "<p>El primer alumno obtenido tiene el nombre: " . $tupla["nombre"] . "</p>";

        $tupla = mysqli_fetch_row($resultado); // Obtener los datos de la bbdd por posición escalar (0, 1, 2, 3, etc)

        echo "<p>El segundo alumno obtenido tiene el nombre: " . $tupla[1] . "</p>";


        $tupla = mysqli_fetch_array($resultado); // Obtener los datos de la bbdd de las 2 formas

        echo "<p>El tercer alumno obtenido tiene el nombre: " . $tupla[1] . "</p>";
        echo "<p>El tercer alumno obtenido tiene el nombre: " . $tupla["nombre"] . "</p>";

        $tupla = mysqli_fetch_object($resultado);
        echo "<p>El tercer alumno obtenido tiene el nombre: " . $tupla->nombre . "</p>";

        mysqli_data_seek($resultado, 0) // Te lleva al principio

        echo "<table>";
        echo "<tr><th>Código</th>Nombre<th>Teléfono</th><th>CP</th></tr>";
        while($tupla = mysqli_fetch_assoc($resultado)){
            echo "<tr>";
                echo "<td>" . $tupla["cod_alu"] . "</td>";
                echo "<td>" . $tupla["nombre"] . "</td>";
                echo "<td>" . $tupla["telefono"] . "</td>";
                echo "<td>" . $tupla["cp"] . "</td>";
            echo "</tr>";
        }

        echo "</table>";

        mysqli_free_result($resultado); // Libera y ya no se puede usar

        //var_dump($tupla);

        mysqli_close($conexion); // Cerrar conexión
    ?>    
</body>
</html>

