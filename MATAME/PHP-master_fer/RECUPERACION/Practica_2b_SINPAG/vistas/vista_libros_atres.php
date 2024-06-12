<?php
echo "<h3>Listado de los libros</h3>";
        

try{

    $resultado=mysqli_query($conexion,"select * from libros");
}
catch(Exception $e)
{
    session_destroy();
    mysqli_close($conexion);
    die("<p>No he podido realizar la consulta: ".$e->getMessage()."</p></body></html>");
}

while($tupla=mysqli_fetch_assoc($resultado))
{
    echo "<p class='libros'>";
    echo "<img src='img/".$tupla["portada"]."' alt='imagen libro' title='imagen libro'><br>";
    echo $tupla["titulo"]." - ".$tupla["precio"]."€";
    echo "</p>";
}

mysqli_free_result($resultado);
?>