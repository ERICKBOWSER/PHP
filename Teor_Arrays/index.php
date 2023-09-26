<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        $nota[0] = 5;
        $nota[1] = 9;
        $nota[2] = 8;
        $nota[3] = 5;
        $nota[4] = 6;
        $nota[5] = 7;

        echo "<h1>Recorrido de un array escalar con sus indices correlativos</h1>";
        for ($i=0; $i < count($nota); $i++) { 
            echo "<p> en la posición: " . $i . " tiene el valor " . $nota[$i] . "</p>";
        }

        $nota2 = array(23,4,21,67,32);

        print_r($nota);
        echo "<br/>";
        var_dump($nota);

        $valor[] = 18;
        $valor[99] = "Hola";
        $valor[] = false; // El false no se muestra al imprimirse
        $valor[200] = 3.4;

        $valor2 = Array(18,99 => "Hola", false, 200 => 3.4);
       
        echo "<h1>Recorrido de un array escalar con sus indices NO correlativos</h1>";

        foreach ($valor as $indice => $contenido) {
            echo "<p>En la posición: " . $indice . " tiene el valor " . $contenido ."</p>";
        }


        var_dump($valor);

        $notas["Antonio"]["DWESE"] = 5;
        $notas["Antonio"]["DWEC"] = 5;
        $notas["Luis"]["DWESE"] = 9;
        $notas["Luis"]["DWEC"] = 7;
        $notas["Ana"]["DWESE"] = 8;
        $notas["Ana"]["DWEC"] = 9;
        $notas["Eloy"]["DWESE"] = 5;
        $notas["Eloy"]["DWEC"] = 6;

/*
        echo "<h1>Notas de DWESE</h1>";
        foreach ($notas as $nombre => $nota) {
            # code...
            echo "<p>" . $nombre . " ha sacado: " . $nota;
        }*/

        echo "<h1>Notas de los alumnos</h1>";

        foreach ($notas as $nombre => $asignatura) {
            # code...
            echo "<p>" . $nombre . ":<ul>";
            foreach ($asignatura as $nombre_asig => $valor){
                # code...
                echo "<li>" . $nombre_asig . ": " . $valor . "</li>" ;

            }
            echo "</ul></p>";

        }


        $capital = array("Castilla y León" => "Valladolid", "Asturias" => "Oviedo", "Aragón" => "Zaragoza");

        echo "<p>Último valor de un array: " .current($capital). "</p>"; // Muestra el primero ya que el puntero esta ene le principio
        echo "<p>Último valor de un array: " .key($capital). "</p>";
        echo "<p>Último valor de un array: " .end($capital). "</p>";

        echo "<p>Último valor de un array: " .current($capital). "</p>"; // Tiene un puntero del anterior, por lo que muestra el último valor de la anterior
        echo "<p>Último valor de un array: " .key($capital). "</p>";

        echo "<p>Último valor de un array: " .reset($capital). "</p>";


        while(current($capital)){
            echo "<strong>" . current($capital) . "</strong> <br/>";
            next($capital);
        }




















































    ?>
</body>
</html>