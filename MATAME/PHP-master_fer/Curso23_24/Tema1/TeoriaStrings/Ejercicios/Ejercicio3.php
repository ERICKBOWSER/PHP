<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio3</title>
    <style>.error{color:red;}</style>
</head>
<body>

        <?php

            //Si los campos estan vacios o no contienen la longitud adecuada
            if (isset($_POST["comparar"])) {

                
                $errorPrimera = $_POST["primera"] == "" || is_numeric($_POST["primera"]);


                $errorFormu = $errorPrimera;
            }


           
        ?>


    <form action="Ejercicio3.php" method="post" enctype="multipart/form-data">

        <div style="background-color:lightblue; border:solid; padding:5px;">

            <h1 style="text-align:center">Palindromos / capicuas - Formulario</h1>

            <p>Dime una frase y te dire si es palindroma</p>
            <p>
                <label for="primera">Frase:</label>
                <input type="text" name="primera" id="primera" value="<?php if(isset($_POST['primera'])) echo trim($_POST['primera'])?>"/>
                <?php
                    if (isset($_POST["comparar"]) && $errorPrimera) {
                        echo "<span class='error'>*Introduce una frase*</span>";
                    }
                ?>
            </p>

            <p>
                <button type="submit" name="comparar">Comprobar</button>
            </p>

        </div>


        <?php

            if (isset($_POST["comparar"]) && !$errorFormu) {

                echo'<div style="background-color:lightgreen; border:solid; margin-top:10px; padding:5px;">';

                    echo'<h1 style="text-align:center">Frases palindromas - Resultado</h1>';



                    $stringC = strtolower(str_replace(' ', '', $_POST['primera']));
                    $reversaLimpia = strrev($stringC);

                    if ($reversaLimpia == $stringC) {

                        echo '<p>'.$_POST['primera'].' es una frase palindroma</p>';

                    }else{

                        echo '<p>'.$_POST['primera'].' no es una frase palindroma</p>';

                    }


                echo'</div>';
                
                
            }

        ?>

        

        
        
    </form>
</body>
</html>