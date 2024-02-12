<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        $array = [1,2,3,4,5,6,7,8,9,10];

        for ($i=0; $i < count($array) ; $i++) { 
            # code...
            echo $array[$i] . "<br>";
        }
    ?>

    <?php
        $array2[1] = 90;
        $array2[30] = 7;
        $array2["e"] = 99;
        $array2["hola"] = 43;

        echo "<hr>";

        foreach ($array2 as $indice => $valor) {
            # code...
            echo $indice . " = " . $valor  . "<br>";
        }

    ?>  

    <?php
        $array3 = ["enero" => 9, "febrero" => 12, "marzo" => 0, "abril" => 17];

        foreach ($array3 as $indice => $valor) {
            # code...
            if($valor != 0){
                echo "mes: " . $indice . " con " . $valor . "<br>";
            }
        }
    ?>
</body>
</html>