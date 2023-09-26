<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        $v[1] = 90;
        $v[30] = 7;
        $v['e'] = 99;
        $v['Hola'] = 43;

        foreach ($v as $indice => $valor) {
            # code...
            echo "<p>El indice es: " . $indice . " y su valor es: " . $valor . "</p>";
        }

        echo "<hr/>";

        foreach ($v as $indice => $valor) {
            # code...
            if(is_numeric($indice)){
                echo "<p>El indice es: " . $indice . " y su valor es: " . $valor . "</p>";
            }else{
                echo "La clave '" .$indice ."' vale " .$valor.".<br/>";
            }
            echo "</p>";
        }
    ?>
</body>
</html>