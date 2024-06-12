<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teoria BD</title>
    <style>
        table,th,td {border:1px solid black;}
        table{border-collapse: collapse; margin: 0 auto; width: 80%; text-align: center;}
        td{background-color: #CCC;}
    </style>
</head>
<body>
    <?php

    try{
        //PARA CONECTARSE A LA BD ("DONDE ESTA MI BASE DE DATOS","USUARIO","CONTRASEÑA","NOMBRE DE LA BD")
        $conexion=mysqli_connect("localhost","jose","josefa","bd_teoria");
        mysqli_set_charset($conexion,"utf8");

    }catch(Exception $e){

        die("<p>No ha podido conectarse a la base de datos: ".$e->getMessage()."</p></body></html>");
    }

    $consulta="select * from t_alumnos"; //CONSULTA A REALIZAR

    //CONTROLAR EXCEPCION
    try {

        //REALIZAR LA CONEXION CON LA CONSULTA
        $resultado=mysqli_query($conexion,$consulta);
        
    } catch (Exception $e) {


        //CERRAR CONEXION
        mysqli_close($conexion);
        die("<p>Imposible realizar la consulta: ".$e->getMessage()."</p></body></html>");
        
    }

    $n_tuplas=mysqli_num_rows($resultado);//OBTENER EL NUMERO DE FILAS

    echo "<p>El numero de tuplas obtenidas ha sido: ".$n_tuplas."</p>";

    $tupla=mysqli_fetch_assoc($resultado); //OBTENGO UN ARRAY CON LA TUPLA
    var_dump($tupla); //IMPRIME EL ARRAY

    echo "<p>El primer alumno obtenido tiene el nombre: ".$tupla["nombre"]."</p>"; //ACCEDER DE FORMASA ASOCIATIVA


    $tupla=mysqli_fetch_row($resultado); // ACCEDER COMO SI FUERA UNA ARRAY

    echo "<p>El segundo alumno obtenido tiene el nombre: ".$tupla[1]."</p>"; 


    $tupla=mysqli_fetch_array($resultado);  // ACCEDER COMO EL ROW Y EL ASSOC

    echo "<p>El tercer alumno obtenido tiene el nombre: ".$tupla[1]."</p>"; 
    echo "<p>El tercer alumno obtenido tiene el nombre: ".$tupla["nombre"]."</p>";


    mysqli_data_seek($resultado,0); //VUELVO AL PRINCIPIO DE LA TUPLA

    $tupla=mysqli_fetch_object($resultado);  // ACCEDER COMO SI FUESE UN OBJETO

    echo "<p>El tercer alumno obtenido tiene el nombre: ".$tupla->nombre."</p>"; 

    mysqli_data_seek($resultado,0);


    echo "<table>";
    echo "<tr><th>Codigo</th><th>Nombre</th><th>Telefono</th><th>CP</th></tr>";
    while ($tupla=mysqli_fetch_assoc($resultado)) {

        echo "<tr>";
        echo "<td>".$tupla["cod_alu"]."</td>";
        echo "<td>".$tupla["nombre"]."</td>";
        echo "<td>".$tupla["telefono"]."</td>";
        echo "<td>".$tupla["cp"]."</td>";
        echo "</tr>";
    }

    echo "</table>";


    mysqli_free_result($resultado);//DESPUES DE TRABAJAR CON DATOS LIBERARLOS
   
    mysqli_close($conexion);

    ?>
</body>
</html>