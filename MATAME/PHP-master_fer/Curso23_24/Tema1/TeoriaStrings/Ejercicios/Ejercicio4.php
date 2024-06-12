<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio4</title>
    <style>.error{color:red;}</style>
</head>
<body>

        <?php

            const VALOR = array("M" => 1000,"D" => 500,"C" => 100,"L" => 50,"X" => 10,"V" => 5,"I" => 10);           

            function letras_bien($texto){
                $bien = true;

                for ($i=0; $i < strlen($texto); $i++) { 
                    if(!isset(VALOR[$texto[$i]])){
                        $bien=false;
                        break;
                    }
                }
                return $bien;
            }

            function orden_bueno($texto){

                $bien = true;

                for ($i=0; $i < strlen($texto)-1; $i++) { 
                    if(VALOR[$texto[$i]]<VALOR[$texto[$i+1]]){
                        $bien=false;
                        break;
                    }
                }
                return $bien;

            }

            function repite_bien($texto){

                $veces["I"]=4;
                $veces["V"]=1;
                $veces["X"]=4;
                $veces["L"]=1;
                $veces["C"]=4;
                $veces["D"]=1;
                $veces["M"]=4;

                $bien = true;

                for ($i=0; $i < strlen($texto); $i++) { 

                    $veces[$texto[$i]]--;
                    if($veces[$texto[$i]]==-1){
                        $bien=false;
                        break;
                    }
                }

                return $bien;

            }


            function es_correcto_romano($texto){

                return letras_bien($texto) && orden_bueno($texto) && repite_bien($texto);

            }

            //Si los campos estan vacios o no contienen la longitud adecuada
            if (isset($_POST["comparar"])) {


                $texto=trim($_POST['primera']);
                $texto_m=strtoupper($texto);
                $errorPrimera = $_POST["primera"] == "" || !es_correcto_romano($texto_m);


                $errorFormu = $errorPrimera;
            }


           
        ?>


    <form action="Ejercicio4.php" method="post" enctype="multipart/form-data">

        <div style="background-color:lightblue; border:solid; padding:5px;">

            <h1 style="text-align:center">Romanos a arabes - Formulario</h1>

            <p>Dime un numero en numeros romanos y lo convertire en cifras arabes</p>
            <p>
                <label for="primera">Numero:</label>
                <input type="text" name="primera" id="primera" value="<?php if(isset($_POST['primera'])) echo trim($_POST['primera'])?>"/>
                <?php
                    if (isset($_POST["comparar"]) && $errorFormu) {

                        if($_POST["primera"]==''){
                            echo "<span class='error'>*Campo vacio*</span>";
                        }else {
                            echo "<span class='error'>*No has escrito un numero romano correcto*</span>";
                        }
                        
                    }
                ?>
            </p>

            <p>
                <button type="submit" name="comparar">Convertir</button>
            </p>

        </div>


        <?php

            if (isset($_POST["comparar"]) && !$errorFormu) {

                $res=0;
                for ($i=0; $i < strlen($texto_m) ; $i++) { 
                    $res+=VALOR[$texto_m[$i]];
                }

                echo'<div style="background-color:lightgreen; border:solid; margin-top:10px; padding:5px;">';

                    echo'<h1 style="text-align:center">Romanos a arabes - Resultado</h1>';

                    echo '<p> El numero '.$texto_m.' se escribe en cifras arabes: '.$res.'</p>';


                echo'</div>';
                
                
            }

        ?>

        

        
        
    </form>
</body>
</html>