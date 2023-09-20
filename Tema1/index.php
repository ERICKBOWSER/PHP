<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        define("PI", 3.1415); // Constante

        // Imprimir texto
        echo "<h1> Mi primera página Curso 23-24</h1>";

        // No hace falta colocar el tipo de dato
        $a = 8;
        $b = 9;

        $c = $b + $a;

        // Con el punto se concatena
        echo "<p>El resultado de sumar " . $a . " + " . $b . " = " . $c . "</p>";

        // Condicional if
        if(3 > $c){
            echo "<p>3 es mayor que " . $c . "</p>";
        }elseif(3 == $c){
            var_dump($c);
            echo "<p>3 es igual que " . $c ."</p>";
        }else{
            echo "<p>3 es menor que " . $c . "</p>";
        }

        $d = 1;
        switch($d){
            case 1: $c = $a - $b; 
            break;

            case 2: $c = $a/$b;
            break;

            case 3: $c = $a * $b;
            break;

            default: $c = $a + $b;
            break;

        }

        echo "<p>El resultado del switch es: " .$c. "</p>";

        for ($i=0; $i < 8; $i++) { 
            echo "<p>Hola " . ($i+1) . "</p>";
        }

        $i = 0;
        while($i <= 8){
            echo "<p>Hola " . ($i+1). "</p>";
            $i++;
        }

    ?>
</body>
</html>






























































