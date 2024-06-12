<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio6</title>
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


    <form action="Ejercicio6.php" method="post" enctype="multipart/form-data">

        <div style="background-color:lightblue; border:solid; padding:5px;">

            <h1 style="text-align:center">Quita acentos - Formulario</h1>

            <p>Escribe un texto y le quitare los acentos</p>
            <p>
                <label for="primera">Texto:</label>
                <textarea name="primera" id="primera" value="<?php if(isset($_POST['primera'])) echo trim($_POST['primera'])?>"></textarea>
                <?php
                    if (isset($_POST["comparar"]) && $errorPrimera) {
                        echo "<span class='error'>*Introduce una frase*</span>";
                    }
                ?>
            </p>

            <p>
                <button type="submit" name="comparar">Quitar acentos</button>
            </p>

        </div>


        <?php

            function eliminar_acentos($cadena){
                    
                //Reemplazamos la A y a
                $cadena = str_replace(
                array('Á', 'À', 'Â', 'Ä', 'á', 'à', 'ä', 'â', 'ª'),
                array('A', 'A', 'A', 'A', 'a', 'a', 'a', 'a', 'a'),
                $cadena
                );

                //Reemplazamos la E y e
                $cadena = str_replace(
                array('É', 'È', 'Ê', 'Ë', 'é', 'è', 'ë', 'ê'),
                array('E', 'E', 'E', 'E', 'e', 'e', 'e', 'e'),
                $cadena );

                //Reemplazamos la I y i
                $cadena = str_replace(
                array('Í', 'Ì', 'Ï', 'Î', 'í', 'ì', 'ï', 'î'),
                array('I', 'I', 'I', 'I', 'i', 'i', 'i', 'i'),
                $cadena );

                //Reemplazamos la O y o
                $cadena = str_replace(
                array('Ó', 'Ò', 'Ö', 'Ô', 'ó', 'ò', 'ö', 'ô'), //Remplaza esto
                array('O', 'O', 'O', 'O', 'o', 'o', 'o', 'o'), //por esto
                $cadena ); //a esto

                //Reemplazamos la U y u
                $cadena = str_replace(
                array('Ú', 'Ù', 'Û', 'Ü', 'ú', 'ù', 'ü', 'û'),
                array('U', 'U', 'U', 'U', 'u', 'u', 'u', 'u'),
                $cadena );
                
                return $cadena;
            }

            if (isset($_POST["comparar"]) && !$errorFormu) {

                echo'<div style="background-color:lightgreen; border:solid; margin-top:10px; padding:5px;">';

                    echo'<h1 style="text-align:center">Quita acentos - Resultado</h1>';

                    echo '<p>Texto original';

                    echo '<p>'.$_POST['primera'].'</p>';

                    echo '<p>Texto sin acentos';

                    echo '<p>'.eliminar_acentos($_POST['primera']).'</p>';
                    

                echo'</div>';
                
                
            }

        ?>

        

        
        
    </form>
</body>
</html>