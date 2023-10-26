<?php
    if(isset($_POST["calcular"])){
        $errorFecha1 = checkdate($_POST["mes1"], $_POST["dia1"], $_POST["anyo1"]);
        $errorFecha2 = checkdate($_POST["mes2"], $_POST["dia2"], $_POST["anyo2"]);

        $errorForm = $errorFecha1 || $errorFecha2;
    }

    function dia(){
        for ($i=0; $i < 32 ; $i++) { 
            # code...
            echo "<option selected value='" . $i . "'>" . $i . "</option>";
        }
    }

            $array[1] = "Enero";
            $array[2] = "Febrero";
            $array[3] = "Marzo";
            $array[4] = "Abril";
            $array[5] = "Mayo";
            $array[6] = "Junio";
            $array[7] = "Julio";
            $array[8] = "Agosto";
            $array[9] = "Septiembre";
            $array[10] = "Octubre";
            $array[11] = "Noviembre";
            $array[12] = "Diciembre";

                
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .cuadro{border:solid; padding:5px}
        .fondoCeleste{background-color: lightblue}
        .fondoVerdoso{background-color: green}
        .centro{text-align: center}
        .error{color:red}
    </style>
</head>
<body>
    <form action="fecha2.php" method="post" enctype="multipart/form-date">
    <p>
            <label for="texto1">Introduzca una fecha: (DD/MM/YYYY)</label><br/><br/>

            <label for="dia1">Día:</label>
            <select name="dia1" id="dia1">
            <?php
                dia();                
            ?>
            </select>

            <label for='mes1'>Mes:</label>
            <select name="mes1" id="mes1">
                <?php
                    for ($i=0; $i <= count($array) ; $i++) { 
                        # code...
                        echo "<option selected value='" . $i . "'>" . $array[$i] . "</option>";
                    }

                ?>
            </select>

            <label for="anyo1">Año:</label>
            <select name="anyo1" id="anyo1">
                <?php
                    $anioActual = date("Y");

                    define("N_ANIOS", 50);

                    for($i = $anioActual - N_ANIOS; $i <= $anioActual; $i++){
                        if(isset($_POST["calcular"]) && $_POST["anyo1"] == $i){
                            echo "<option selected value='" . $i . "'>" . $i . "</option>";
                        }else{
                            echo "<option value='" . $i . "'>" . $i . "</option>";
                        }
                    }

                ?>
            </select>   
            
            <?php
                if(isset($_POST["calcular"]) && $errorFecha1){
                    echo "<span class='error'>Fecha no valida</span";                }

            ?>
        </p>
        <p>
            <label for="texto1">Introduzca una fecha: (DD/MM/YYYY)</label><br/><br/>

            <label for="dia2">Día:</label>
            <select name="dia2" id="dia2">
            <?php
                dia();                
            ?>
            </select>

            <label for='mes2'>Mes:</label>
            <select name="mes2" id="mes2">
                <?php
                    for ($i=0; $i <= count($array) ; $i++) { 
                        # code...
                        echo "<option selected value='" . $i . "'>" . $array[$i] . "</option>";
                    }

                ?>
            </select>

            <label for="anyo2">Año:</label>
            <select name="anyo2" id="anyo2">
                <?php
                    $anioActual = date("Y");

                    define("N_ANIOS", 50);

                    for($i = $anioActual - N_ANIOS; $i <= $anioActual; $i++){
                        if(isset($_POST["calcular"]) && $_POST["anyo2"] == $i){
                            echo "<option selected value='" . $i . "'>" . $i . "</option>";
                        }else{
                            echo "<option value='" . $i . "'>" . $i . "</option>";
                        }
                    }

                ?>
            </select>            
            <?php
                if(isset($_POST["calcular"]) && $errorFecha2){
                    echo "<span class='error'>Fecha no valida</span";                }

            ?>
        </p>
        <button type="submit" name="calcular" id="calcular">Calcular</button>
    </form>
    
</body>
</html>
<?php
    if(isset($_POST["calcular"]) && !$errorForm){
        $convertir1 = strtotime($_POST["anyo1"] . "/" . $_POST["mes1"] . "/" . $_POST["dia1"]);
        $convertir2 = strtotime($_POST["anyo2"] . "/" . $_POST["mes2"] . "/" . $_POST["dia2"]);

        $difSegundos = abs($convertir1 - $convertir2);
        $diasPasados = $difSegundos / (60 * 60 * 24);

        echo "<div class = 'cuadro fondo_verdoso'>";
        echo "<h1 class='centro'>Fechas - Respuestas</h1>";
        echo "<p>La diferencia en días entre las dos fechas introducidas es de: " . floor($diasPasados) . "</p>";
    echo "</div>";

    }

?>