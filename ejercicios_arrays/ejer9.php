<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        $lenguajes_cliente = array("LC1" => "Lenguaje_Cliente1", "LC2" => "Lenguaje_Cliente2");
        $lenguajes_servidor = array("LS1" => "Lenguaje_Servidor1", "LS2" => "Lenguaje_Servidor2", "LS3" => "Lenguaje_Servidor3");



        $lenguajes = array_merge($lenguajes_cliente, $lenguajes_servidor);

        //print_r($lenguajes);

        for ($i=0; $i < count($lenguajes_servidor); $i++) { 
            # code...
            array_push($lenguajes_cliente, $lenguajes_servidor[$i]);
        }

        foreach ($lenguajes_cliente as $indice => $valor) {
            # code...

            echo $valor;
        }

    ?>
    
</body>
</html>