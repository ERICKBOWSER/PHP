<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio1</title>
    <style>.error{color:red;}</style>
</head>
<body>

        <?php

            //Si los campos estan vacios o no contienen la longitud adecuada
            if (isset($_POST["comparar"])) {

                
                $errorPrimera = $_POST["primera"] == "" || strlen(trim($_POST["primera"])) <3;

                

                $errorSegunda = $_POST["segunda"] == "" || strlen(trim($_POST["segunda"])) < 3;

                $errorFormu = $errorPrimera || $errorSegunda;
            }


           
        ?>


    <form action="Ejercicio1.php" method="post" enctype="multipart/form-data">

        <div style="background-color:lightblue; border:solid; padding:5px;">

            <h1 style="text-align:center">Ripios - Formulario</h1>

            <p>Dime dos palabras y te dire si riman o no</p>
            <p>
                <label for="primera">Primera palabra :</label>
                <input type="text" name="primera" id="primera" value="<?php if(isset($_POST['primera'])) echo $_POST['primera']?>"/>
                <?php
                    if (isset($_POST["comparar"]) && $errorPrimera) {
                        echo "<span class='error'>*Introduce una palabra de al menos 3 letras*</span>";
                    }
                ?>
            </p>
            <p>
                <label for="segunda">Segunda palabra:</label>
                <input type="text" name="segunda" id="segunda" value="<?php if(isset($_POST['segunda'])) echo $_POST['segunda']?>"/>
                <?php
                    if (isset($_POST["comparar"]) && $errorSegunda) {
                        echo "<span class='error'>*Introduce una palabra de al menos 3 letras*</span>";
                    }
                ?>
                
            </p>

            <p>
                <button type="submit" name="comparar">Comparar</button>
            </p>

        </div>


        <?php

            if (isset($_POST["comparar"]) && !$errorFormu) {

                echo'<div style="background-color:lightgreen; border:solid; margin-top:10px; padding:5px;">';

                    echo'<h1 style="text-align:center">Ripios - Resultado</h1>';

                    if(substr(strtolower($_POST['primera']),-3) == substr(strtolower($_POST['segunda']),-3)){

                        echo '<p>'.$_POST['primera'].' y '.$_POST['segunda'].' riman</p>';

                    }elseif(substr(strtolower($_POST['primera']),-3) == substr(strtolower($_POST['segunda']),-2)){
                        
                        echo '<p>'.$_POST['primera'].' y '.$_POST['segunda'].' riman un poco</p>';

                    }else {

                        echo '<p>'.$_POST['primera'].' y '.$_POST['segunda'].' no riman</p>';
                    }

                echo'</div>';
                
                
            }

        ?>

        

        
        
    </form>
</body>
</html>