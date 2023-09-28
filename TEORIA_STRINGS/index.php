<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teoría de String</title>
</head>
<body>
    <?php
        $str1 = "        Hola que tal?             ";
        $str1 = trim($str1);
        $str2 = "Juan";

        echo "<h1>" . $str1 . $str2 . "</h1>";

        $longitud = strlen($str1);

        echo "<p>La longitud del String: '" . $str1 . "' es: " . $longitud . "</p>";

        $str1[12] = "!"; // Cambia el dato
        echo "<p>" . $str1 . "</p>";
        echo "<p>" . strtoupper($str2) . "</p>";
        echo "<p>" . $str2 . "</p>";

        $prueba = "Hola mi nombre es Guerig Eri";
        $sep_arr = explode(" ", $prueba); // Crea array por cada parametro que se le pase de separación

        print_r($sep_arr);

        $prueba2 = "asjkofasl.jpg";
        $sep_arr = explode(".", $prueba2); // Crea array por cada parametro que se le pase de separación
        echo "<p>Extensión leida es: " .end($sep_arr) . "</p>";

        $arr_prueba = array("hola", "Juan", "Antonio", 12, "Maria");
        print_r($arr_prueba);

        $str3 = implode(":::", $arr_prueba); // Crea un string juntando todos los elementos
        echo "<p>" . $str3 . "</p>";

        echo "<p>" .substr("Hola que tal, Juan", 0, 8) . "</p>" // Normalmente tiene 3 valores

    ?>
</body>
</html>