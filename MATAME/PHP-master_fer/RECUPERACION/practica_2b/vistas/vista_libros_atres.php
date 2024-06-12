<?php
echo "<h3>Listado de los libros</h3>";

try {

    $consulta = "select * from libros";
    $sentencia = $conexion->prepare($consulta);
    $sentencia->execute();
} catch (PDOException $e) {
    $sentencia = null;
    $conexion = null;
    session_destroy();
    die(error_page("Práctica Rec 2", "<h1>Práctica Rec 2</h1><p>Imposible realizar la consulta. Error:" . $e->getMessage() . "</p>"));
}
$libros = $sentencia->fetchAll(PDO::FETCH_ASSOC);

foreach ($libros as  $tupla) {
    echo "<p class='libros'>";
    echo "<img src='img/" . $tupla["portada"] . "' alt='imagen libro' title='imagen libro'><br>";
    echo $tupla["titulo"] . " - " . $tupla["precio"] . "€";
    echo "</p>";
}

$conexion = null;
$sentencia = null;
session_destroy();
