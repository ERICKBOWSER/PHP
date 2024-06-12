<?php
echo "<h3>Detalles del usuario con id: ".$_POST["btnDetalle"]."</h3>";

try{
        
    $consulta="select * from usuarios where id_usuario=?";
    $sentencia=$conexion->prepare($consulta);
    $sentencia->execute([$_POST["btnDetalle"]]);
}
catch(PDOException $e)
{
    $sentencia=null;
    $conexion=null;
    session_destroy();
    die("<p>No se ha podido realizar la consulta: ".$e->getMessage()."</p></body></html>");
}




if($sentencia->rowCount()>0)
{
    $datos_usuario=$sentencia->fetch(PDO::FETCH_ASSOC);
    $sentencia=null;

    echo "<p>";
    echo "<strong>Nombre: </strong>".$datos_usuario["nombre"]."<br>";
    echo "<strong>Usuario: </strong>".$datos_usuario["usuario"]."<br>";
    echo "<strong>Email: </strong>".$datos_usuario["email"];
    echo "</p>";
}
else
    echo "<p>El usuario seleccionado ya no se encuentra registrado en la BD</p>";


echo "<form action='index.php' method='post'>";
echo "<p><button type='submit'>Volver</button></p>";
echo "</form>";

?>