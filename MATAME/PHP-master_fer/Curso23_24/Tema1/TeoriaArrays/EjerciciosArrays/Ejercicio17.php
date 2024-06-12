<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio17</title>
</head>
<body>
    <?php

    
    
        $familias = array (
            "Los Simpsons"=>array("Padre" => "Homer","Madre" => "Marge","Hijos"=>array("Hijo1" => "Bart","Hijo2" => "Lisa","Hijo3" => "Maggie")),
            "Los Griffin"=>array("Padre" => "Peter","Madre" => "Lois","Hijos"=>array("Hijo1"=>"Chris","Hijo2"=>"Meg","Hijo3"=>"Stewie"))
        ); 



        echo "<ul>";
        foreach ($familias as $indice => $profesion) {
            echo "<li>";
            echo $indice;
            echo "<ul>";
                foreach ($profesion as $indice2 => $nombres) {
                    echo "<li>";
                    echo $indice2.": ";
                    if(is_array($nombres)){
                        echo "<ul>";
                        foreach ($nombres as $indice3 => $valor) {
                            echo "<li>";
                            echo $indice3.": ";
                            echo $valor;
                            echo "</li>";
                        }
                        echo "</ul>";
                    }else {
                        echo $nombres;
                    }
                    echo "</li>";
                }
            echo "</ul>";
            echo "</li>";
        }
        echo "</ul>";
        
    ?>
</body>
</html>