<?php
    if(isset($_POST["btnCalcular"])){
        $errorFecha1 = !checkdate($_POST["mes1"], $_POST["dia1"], $_POST["anyo1"]);
        $errorFecha2 = !checkdate($_POST["mes2"], $_POST["dia2"], $_POST["anyo2"]);

    }

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
    <div class="cuadro fondoCeleste">
    <h1>Fechas - Formulario</h1>

    <form action="fecha2.php" method="post">
        <p>
            <label for="texto1">Introduzca una fecha:</label><br/>

            <label for="dia1">Día: </label>
            <select name="dia1" id="dia1">
                <?php
                    for ($i=0; $i < 32; $i++) { 
                        # code...
                        if(isset($_POST["btnCalcular"]) && $_POST["dia1"] == $i){
                            echo "<option selected value='" . $i . "'>" . $i . "</option>";
                        }else{
                            echo "<option value='" . $i . "'>" . $i . "</option>";
                        }

                    }
                ?>
            </select>

            <label for="mes1">Mes: </label>
            <select name="mes1" id="mes1">
                <?php
                    $mes = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");

                    for ($i=0; $i < count($mes); $i++) { 
                        # code...
                        if(isset($_POST["btnCalcular"]) && $_POST["mes1"] == $i){
                            echo "<option selected value='" . $mes[$i] . "'>" . $mes[$i] . "</option>";
                        }else{
                            echo "<option value='" . $mes[$i] . "'>" . $mes[$i] . "</option>";
                        }
                    }

                ?>
            </select>

            <label for="anyo1">Año: </label>
            <select name="anyo1" id="anyo1">
                <?php

                    // Año actual
                    $anioActual = date("Y");

                    // -_-
                    define("N_ANIOS", 50);

                    for ($i = $anioActual - N_ANIOS; $i <= $anioActual; $i++) { 
                        # code...

                        if(isset($_POST["btnCalcular"]) && $_POST["anyo1"] == $i){
                            echo "<option selected value='" . $i . "'>" . $i . "</option>"; // SELECCIONADO
                        }else{
                            echo "<option value='" . $i . "'>" . $i . "</option>";
                        }
                    }

                ?>
            </select>

        
            <?php
                if(isset($_POST["btnCalcular"]) && $errorFecha1){
                    if($_POST["texto1"] == ""){
                        echo "<span class='error'>Campo vacío</span";
                    }else{
                        echo "<span class='error'>Fecha no valida</span";
                    }
                }

                if(isset($_POST["btnCalcular"]) && $errorFecha1){
                    echo "Fecha no valida";
                }
            ?>
        </p>
        <label for="texto1">Introduzca una fecha:</label><br/>

    <label for="dia2">Día: </label>
    <select name="dia2" id="dia2">
        <?php
            for ($i=0; $i < 32; $i++) { 
                # code...
                if(isset($_POST["btnCalcular"]) && $_POST["dia2"] == $i){
                    echo "<option selected value='" . $i . "'>" . $i . "</option>";
                }else{
                    echo "<option value='" . $i . "'>" . $i . "</option>";
                }

            }
        ?>
    </select>

    <label for="mes2">Mes: </label>
    <select name="mes2" id="mes2">
        <?php
            $mes = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");

            for ($i=0; $i < count($mes); $i++) { 
                # code...
                if(isset($_POST["btnCalcular"]) && $_POST["mes2"] == $i){
                    echo "<option selected value='" . $mes[$i] . "'>" . $mes[$i] . "</option>";
                }else{
                    echo "<option value='" . $mes[$i] . "'>" . $mes[$i] . "</option>";
                }
            }

        ?>
    </select>

    <label for="anyo2">Año: </label>
    <select name="anyo2" id="anyo2">
        <?php

        // Año actual
        $anioActual = date("Y");

        // -_-
        define("N_ANIOS", 50);

        for ($i = $anioActual - N_ANIOS; $i <= $anioActual; $i++) { 
            # code...
            if(isset($_POST["btnCalcular"]) && $_POST["anyo2"] == $i){
                echo "<option selected value='" . $i . "'>" . $i . "</option>"; // SELECCIONADO
            }else{
                echo "<option value='" . $i . "'>" . $i . "</option>";
            }
        }

        ?>
    </select>


    <?php
        if(isset($_POST["btnCalcular"]) && $errorFecha2){
            if($_POST["texto1"] == ""){                
                echo "<span class='error'>Fecha no valida</span";
            }
        }
    ?>
    </p>
        
        <button type="submit" name="btnCalcular" id="btnCalcular">Calcular</button>
    </form>
    </div>

    <?php
        if(isset($_POST["btnCalcular"]) && !$errorForm){
            $tiempo1 = strtotime($_POST["anyo1"] . "/" . $_POST["mes1"] . "/" . $_POST["dia1"]);
            $tiempo2 = strtotime($_POST["anyo2"] . "/" . $_POST["mes2"] . "/" . $_POST["dia2"]);

            $difSegundos = abs($tiempo1 - $tiempo2);
            $diasPasados = $difSegundos / (60 * 60 * 24);

            echo "<div class = 'cuadro fondo_verdoso'>";
            echo "<h1 class='centro'>Fechas - Respuestas</h1>";
            echo "<p>La diferencia en días entre las dos fechas introducidas es de: " . floor($diasPasados) . "</p>";
            echo "</div>";
        }
    ?>

</body>
</html>


