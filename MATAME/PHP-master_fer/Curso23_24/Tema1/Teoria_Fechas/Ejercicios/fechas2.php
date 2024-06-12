<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>fechas2</title>
    <style>.error{color:red;}</style>
</head>
<body>
    <?php
    if(isset($_POST["calcular"])){

        $error_fecha1=!checkdate($_POST["meses1"],$_POST["dias1"],$_POST["años1"]);
        $error_fecha2=!checkdate($_POST["meses2"],$_POST["dias2"],$_POST["años2"]);
        
        $error_formu = $error_fecha1 || $error_fecha2;

    }
       

        $mes[1]="Enero";
        $mes[2]="Febrero";
        $mes[3]="Marzo";
        $mes[4]="Abril";
        $mes[5]="Mayo";
        $mes[6]="Junio";
        $mes[7]="Julio";
        $mes[8]="Agosto";
        $mes[9]="Septiembre";
        $mes[10]="Octubre";
        $mes[11]="Noviembre";
        $mes[12]="Diciembre";
    ?>



    <form action="fechas2.php" method="post" enctype="multipart/form-data">

        <div style="background-color:lightblue; border:solid; padding:5px;">

            <h1 style="text-align:center">Fechas - Formulario</h1>

            <p>
                <label>Introduzca una fecha:</label>
            </p>

            <p>
                <label for="dias1">Dia:</label>
                <select name="dias1" id="dias1">

                    <?php
                        for ($i=1; $i <= 31; $i++) { 
                            if(isset($_POST["calcular"]) && $_POST["dias1"]==$i){

                                echo "<option selected value=".$i.">".sprintf("%02d",$i)."</option>";
                            
                            }else{
                                echo "<option value=".$i.">".sprintf("%02d",$i)."</option>";
                            }
                            
                        }

                    ?>
                    
                </select>

                <label for="meses1">Mes:</label>

                <select name="meses1" id="meses1">

                    <?php
                        for ($i=1; $i<count($mes); $i++) { 


                            if(isset($_POST["calcular"]) && $_POST["meses1"]==$i){
    
                                echo "<option selected value=".$i.">".$mes[$i]."</option>";
                            
                            }else{
    
                                echo "<option value=".$i.">".$mes[$i]."</option>";
                            }
    
                        }
    
    

                    ?>
                </select>
                <label for="años1">Año:</label>
                <select name="años1" id="años1">

                    <?php

                        for ($i=date("Y"); $i >= (date("Y")-50); $i--) { 


                            if(isset($_POST["calcular"]) && $_POST["años1"]==$i){

                                echo "<option selected value=".$i.">".$i."</option>";
                            
                            }else{

                                echo "<option value=".$i.">".$i."</option>";
                            }
                            
                        }

                        echo "</select>";

                        if(isset($_POST["calcular"]) && $error_fecha1){
                            echo "<span class='error'>Fecha no valida</span>";
                        }

                    ?>

                
            </p>



            <p>
                <label>Introduzca una fecha:</label>
            </p>

            <p>
                <label for="dia2">Dia:</label>
                <select name="dias2" id="dias2">

                    <?php
                        for ($i=1; $i <= 31; $i++) { 
                            if(isset($_POST["calcular"]) && $_POST["dias2"]==$i){

                                echo "<option selected value=".$i.">".sprintf("%02d",$i)."</option>";
                            
                            }else{
                                echo "<option value=".$i.">".sprintf("%02d",$i)."</option>";
                            }
                            
                        }

                    ?>
                    
                </select>

                <label for="mes2">Mes:</label>

                <select name="meses2" id="meses2">

                    <?php
                        for ($i=1; $i<count($mes); $i++) { 


                        if(isset($_POST["calcular"]) && $_POST["meses2"]==$i){

                            echo "<option selected value=".$i.">".$mes[$i]."</option>";
                        
                        }else{

                            echo "<option value=".$i.">".$mes[$i]."</option>";
                        }

                        }

                        echo "</select>";

                    ?>

               
                <label for="año2">Año:</label>
                <select name="años2" id="años2">

                    <?php
                         for ($i=date("Y"); $i >= (date("Y")-50); $i--) { 


                            if(isset($_POST["calcular"]) && $_POST["años2"]==$i){

                                echo "<option selected value=".$i.">".$i."</option>";
                            
                            }else{

                                echo "<option value=".$i.">".$i."</option>";
                            }
                            
                        }

                        echo "</select>";

                        if(isset($_POST["calcular"]) && $error_fecha2){
                            echo "<span class='error'>Fecha no valida</span>";
                        }
                    ?>

               
            </p>
        
           

            <p>
                <button type="submit" name="calcular">Calcular</button>
            </p>

        </div>


        <?php

            if (isset($_POST["calcular"]) && !$error_formu) {

                echo'<div style="background-color:lightgreen; border:solid; margin-top:10px; padding:5px;">';

                    echo'<h1 style="text-align:center">Fechas - Respuesta</h1>';

                    $tiempo1=strtotime($_POST["años1"]."/".$_POST["meses1"]."/".$_POST["dias1"]);
                    $tiempo2=strtotime($_POST["años2"]."/".$_POST["meses2"]."/".$_POST["dias2"]);

                    $dif_segundos=abs($tiempo1-$tiempo2);
                    $dias_pasados=floor($dif_segundos/(60*60*24));


                    echo "<p>La diferencia de las 2 fechas introducidas es de ".$dias_pasados." dias</p>";

                echo'</div>';
                
                
            }

        ?>
  
    </form>
</body>
</html>