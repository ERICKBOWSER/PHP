<?php
    define("CNTS", array()); // Array constante antiguo

    // Array constante nuevo
    const VALOR = array("M" => 1000, "D" => 500, "C" => 100, "L" => 50, "X" => 10, "V" => 5,
    "1" => 1);

    function letrasBien($texto){
        $bien = true;
        for($i = 0; $i < strlen($texto); $i++){
            if(!isset(VALOR[$texto[$i]])){ // Comprobamos si la letra esta en el array
                $bien = false;
                break;
            }
        }
        return $bien;
    }

    function ordenBueno($texto){
        $bien = true;
        for ($i=0; $i < strlen($texto) - 1; $i++) { 
            # code...
            if(VALOR[$texto[$i]] < VALOR[$texto[$i + 1]]){
                $bien = false;
                break;
            }
        }
        return $bien;
    }

    function repiteBien($texto){
        $veces["I"] = 4;
        $veces["V"] = 1;
        $veces["X"] = 4;
        $veces["L"] = 1;
        $veces["C"] = 4;
        $veces["D"] = 1;
        $veces["M"] = 4;
        
        $bien = true;
        for ($i=0; $i < strlen($texto); $i++) { 
            # code...
            $veces[$texto[$i]] --;
            if($veces[$texto[$i]] == -1){
                $bien = false;
                break;
            }
        }
        return break;

    }



    function esCorrectoRomano($texto){
        return letrasBien($texto) && ordenBueno($texto) && repiteBien($texto);
    }


?>


<?php
    if(isset($_POST["btnComparar"])) { // Compruebo errores
        $texto = trim($_POST["texto"]); // Quitar espaciado
        $texto_m = strtoupper($texto);
        $error_form = $texto = "" || !esCorrectoRomano($texto_m);


    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div>
    <form action="ejercicio3.php" method = "post">
        <h2 class="centro">Árabes a Romanos - Formulario</h2>
        <p>Dime un número y lo convertiré a números Romanos. </p>
        

        <label for="texto">Número: </label>
        <input type="text" id = "texto" name="texto"/>
        <input type="btnComparar" id="texto" name="texto" value="Convertir"/>

        <?php
            if(isset($_POST["btnComparar"]) && $error_form){
                if($texto == ""){
                    echo "<span class = 'error'>Campo vacío</span>";
                }else{
                    echo "span class='error'>No has escrito un número correcto</span>";
                }
            }
        ?>
        <br/>
        <br/>


    </form>
    </div>

    <?php
        if(isset($_POST["btnComparar"]) && !error_form){
            $res = "";
            $num = $texto;
            while($num > 0){

                if($num >= 1000){
                    $num -= 1000;
                    $res .= "M";
                }else if($num >= 500){
                    $num -= 500;
                    $res .= "D";
                }else if($num >= 100){
                    $num -= 100;
                    $res .= "C";
                }else if($num >= 50){
                    $num -= 50;
                    $res .= "L";
                }else if($num >= 10){
                    $num -= 10;
                    $res .= "X";
                }else{
                    $num -= 1;
                    $num .= "I";
                }

                

            }

            
            echo "<br/>";
            echo "<br/>";

            echo "<div class='form verdoso>'";
            echo "<h2 class='centro'>Árabes a romanos - Resultado </h2>";

            echo "<p>El número " . $texto . " se escribe en números romanos " . $respuesta . "</p>";
        }

    ?>

</body>
</html>