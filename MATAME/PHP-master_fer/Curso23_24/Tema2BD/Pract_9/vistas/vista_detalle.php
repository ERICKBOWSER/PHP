<?php
try{
    $conexion=mysqli_connect(SERVIDOR_BD,USUARIO_BD,CLAVE_BD,NOMBRE_BD);
    mysqli_set_charset($conexion,"utf8");
}
catch(Exception $e)
{
    die("<p>No ha podido conectarse a la base de batos: ".$e->getMessage()."</p></body></html>");
}

echo "<h3>Detalles de la pelicula con id: ".$_POST["btnDetalle"]."</h3>";
try{
    $consulta="select * from peliculas where idPelicula='".$_POST["btnDetalle"]."'";
    $resultado=mysqli_query($conexion, $consulta);
}
catch(Exception $e)
{
    mysqli_close($conexion);
    die("<p>No se ha podido realizar la consulta: ".$e->getMessage()."</p></body></html>");
}

if(mysqli_num_rows($resultado)>0)
{
    $datos_pelicula=mysqli_fetch_assoc($resultado);
    mysqli_free_result($resultado);

    echo "<p>";
    echo "<strong>Titulo: </strong>".$datos_pelicula["titulo"]."<br>";
    echo "<strong>Director: </strong>".$datos_pelicula["director"]."<br>";
    echo "<strong>Sinopsis: </strong>".$datos_pelicula["sinopsis"]."<br>";
    echo "<strong>Tematica: </strong>".$datos_pelicula["tematica"]."<br>";
    echo "<strong>Caratula: </strong><br><img class='caratula_detalle' src='Img/".$datos_pelicula["caratula"]."' alt='Caratula' title='Caratula'>";
    echo "</p>";
}
else
    echo "<p>La pelicula seleccionada ya no se encuentra registrado en la BD</p>";


echo "<form action='index.php' method='post'>";
echo "<p><button type='submit'>Volver</button></p>";
echo "</form>";

?>