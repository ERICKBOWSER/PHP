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
            
            function buenos_separadores($fecha) {
                return substr($fecha,2,1) =="/" && substr($fecha,5,1) =="/";
            }

            function numeros_buenos($fecha){
                return is_numeric(substr($fecha,0,2)) &&  is_numeric(substr($fecha,3,2)) &&  is_numeric(substr($fecha,6,4));
            }

            function fecha_valida($fecha){  
                return checkdate(substr($fecha,3,2),substr($fecha,0,2),substr($fecha,6,4));
            }

            //Si los campos estan vacios o no contienen la longitud adecuada
            if (isset($_POST["calcular"])) {

                $errorFecha1 = $_POST["fecha1"] == "" || strlen($_POST["fecha1"])!=10 || !buenos_separadores($_POST["fecha1"]) || !numeros_buenos($_POST["fecha1"]) || !fecha_valida($_POST["fecha1"]);

                $errorFecha2 = $_POST["fecha2"] == "" || strlen($_POST["fecha2"])!=10 || !buenos_separadores($_POST["fecha2"]) || !numeros_buenos($_POST["fecha2"]) || !fecha_valida($_POST["fecha2"]);


                $errorFormu = $errorFecha1 || $errorFecha2;
            }


           
        ?>


    <form action="fechas1.php" method="post" enctype="multipart/form-data">

        <div style="background-color:lightblue; border:solid; padding:5px;">

            <h1 style="text-align:center">Fechas - Formulario</h1>

            <p>
                <label for="fecha1">Introduzca una fecha: (DD//MM/YYYY)</label>
                <input type="text" name="fecha1" id="fecha1" value="<?php if(isset($_POST['fecha1'])) echo $_POST['fecha1']?>"/>
                <?php
                    if (isset($_POST["calcular"]) && $errorFecha1) {

                        if($_POST["fecha1"] ==""){

                            echo "<span class='error'>*Campo vacio*</span>";

                        }else {

                            echo "<span class='error'>*Fecha no valida*</span>";
                        }
        
                    }
                ?>
            </p>
            <p>
            <label for="fecha2">Introduzca una fecha: (DD//MM/YYYY)</label>
                <input type="text" name="fecha2" id="fecha2" value="<?php if(isset($_POST['fecha2'])) echo $_POST['fecha2']?>"/>
                <?php
                    if (isset($_POST["calcular"]) && $errorFecha2) {

                        if($_POST["fecha2"] == ""){

                            echo "<span class='error'>*Campo vacio*</span>";

                        }else {

                            echo "<span class='error'>*Fecha no valida*</span>";
                        }
                    }
                ?>
                
            </p>

            <p>
                <button type="submit" name="calcular">Calcular</button>
            </p>

        </div>


        <?php

            if (isset($_POST["calcular"]) && !$errorFormu) {

                echo'<div style="background-color:lightgreen; border:solid; margin-top:10px; padding:5px;">';

                    echo'<h1 style="text-align:center">Fechas - Respuesta</h1>';

                    $array_fecha1=explode("/",$_POST["fecha1"]);
                    $array_fecha2=explode("/",$_POST["fecha2"]);

                    $tiempo1=mktime(0,0,0,$array_fecha1[1],$array_fecha1[0],$array_fecha1[2]);
                    $tiempo2=mktime(0,0,0,$array_fecha2[1],$array_fecha2[0],$array_fecha2[2]);

                    $dif_segundos=abs($tiempo1-$tiempo2);
                    $dias_pasados=floor($dif_segundos/(60*60*24));


                    echo "<p>La diferencia de las 2 fechas introducidas es de ".$dias_pasados." dias</p>";

                echo'</div>';
                
                
            }

        ?>

        

        
        
    </form>
</body>
</html>