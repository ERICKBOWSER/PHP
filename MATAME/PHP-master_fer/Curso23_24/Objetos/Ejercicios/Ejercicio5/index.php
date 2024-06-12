<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio5 POO</title>
</head>
<body>
    <h1>Ejercicio5 POO</h1>
    <?php
        require "class_empleado.php";

        $empleado1=new Empleado("Pepe","3100");
        $empleado2=new Empleado("Juan","2999");

        echo "<h2>Informacion de mis empleados</h2>";
      
        $empleado1->impuestos();
        echo "</br></br>";
        $empleado2->impuestos();
    ?>
</body>
</html>