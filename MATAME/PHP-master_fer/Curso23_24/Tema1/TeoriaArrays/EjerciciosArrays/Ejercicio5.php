<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio5</title>
</head>
<body>

    <?php

        $persona['Nombre']='Pedro Torres';
        $persona['Direccion']='C/Mayor,37';
        $persona['Telefono']=123456789;



        foreach ($persona as $datos => $valor) {
            echo "<p>".$datos.": ".$valor."</p>";
        }

    ?>
    
</body>
</html>