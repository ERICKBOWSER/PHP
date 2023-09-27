<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        $usuario = array("nombre" => "Pedro Torres", "direccion" => "C/ Mayor, 37", "telefono" => 123456789);
        
        echo "<p>El nombre del usuario es " . $usuario["nombre"] . "</p>";
        echo "<p>La dirección es " . $usuario["direccion"] . "</p>";
        echo "<p>El teléfono es " . $usuario["telefono"] . "</p>";
    ?>
    
</body>
</html>