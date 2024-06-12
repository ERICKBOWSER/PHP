<?php
if(!isset($conexion))
{
    try{
        $conexion=mysqli_connect(SERVIDOR_BD,USUARIO_BD,CLAVE_BD,NOMBRE_BD);
        mysqli_set_charset($conexion,"utf8");
    }
    catch(Exception $e)
    {
        die("<p>No ha podido conectarse a la base de batos: ".$e->getMessage()."</p></body></html>");
    }
}
try{
    $consulta="select * from peliculas";
    $resultado=mysqli_query($conexion, $consulta);
}
catch(Exception $e)
{
    mysqli_close($conexion);
    die("<p>No se ha podido realizar la consulta: ".$e->getMessage()."</p></body></html>");
}

echo "<h2>Listado de las peliculas</h2>";
echo "<table>";
echo "<tr><th>id</th><th>Titulo</th><th>Caratula</th><th><form action='index.php' method='post'><button class='enlace' type='submit' name='btnNuevaPelicula'>Peliculas+</button></form></th></tr>";
while($tupla=mysqli_fetch_assoc($resultado))
{
    echo "<tr>";
    echo "<td>".$tupla["idPelicula"]."</td>";
    echo "<td><form action='index.php' method='post'><button class='enlace' type='submit' value='".$tupla["idPelicula"]."' name='btnDetalle' title='Detalles del Usuario'>".$tupla["titulo"]."</button></form></td>";
    echo "<td><img src='Img/".$tupla["caratula"]."' alt='caratula de Perfil' title='caratula de Perfil'></td>";
    echo "<td><form action='index.php' method='post'><input type='hidden' name='nombre_caratula' value='".$tupla["caratula"]."'><button class='enlace' type='submit' value='".$tupla["idPelicula"]."' name='btnBorrar'>Borrar</button> - <button class='enlace' type='submit' value='".$tupla["idPelicula"]."' name='btnEditar'>Editar</button></form></td>";
    echo "</tr>";
}
echo "</table>";
mysqli_free_result($resultado);
mysqli_close($conexion);
?>