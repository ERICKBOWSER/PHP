<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php

        $familias["Los Simpsons"]["Padre"] = "Homer";
        $familias["Los Simpsons"]["Madre"] = "Marge";
        $familias["Los Simpsons"]["Hijos"]["Hijo1"] = "Bart";
        $familias["Los Simpsons"]["Hijos"]["Hijo2"] = "Lisa";
        $familias["Los Simpsons"]["Hijos"]["Hijo3"] = "Maggie";
        $familias["Los Grifin"]["Padre"] = "Peter";
        $familias["Los Grifin"]["Madre"] = "Lois";
        $familias["Los Grifin"]["Hijos"]["Hijo1"] = "Chris";
        $familias["Los Grifin"]["Hijos"]["Hijo2"] = "Meg";
        $familias["Los Grifin"]["Hijos"]["Hijo3"] = "Stewie";

        echo "<ul>";
        foreach($familias as $familia => $valores){
            echo "<li>" . $familia;
                echo "<ul>";
                foreach($valores as $parentesco => $nombres){

                    if($parentesco == "hijos"){
                        echo "<li>" . $parentesco . ": ";

                            echo "<ul>";
                            foreach($nombres as $n_hijo => $nombre){
                                echo "<li>" . $n_hijo . ": " . $nombre . "</li>";
                            }
                            echo "</ul>";

                        echo "</li>";
                    }else{
                        echo "<li>" . $parentesco . ": " . $nombres . "</li>";
                    }
                }           
                echo "</ul>";
            echo "</li>";
        }
        echo "</ul>"


    ?>    
</body>
</html>