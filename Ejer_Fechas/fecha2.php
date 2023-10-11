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

    <form action="fecha1.php" method="post">
        <p>
            <label for="texto1">Introduzca una fecha:</label><br/>

            <label for="dia">Día: </label>
            <select name="dia" id="dia">
                <?php
                    for ($i=0; $i < 32; $i++) { 
                        # code...
                        echo "<option value='" . $i . "'>" . $i . "</option>";

                    }
                ?>
            </select>

            <label for="mes">Mes: </label>
            <select name="mes" id="mes">
                <?php
                    $mes = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");

                    for ($i=0; $i < count($mes); $i++) { 
                        # code...
                        echo "<option value='" . $mes[$i] . "'>" . $mes[$i] . "</option>";
                    }

                ?>
            </select>

            <label for="anyo">Año: </label>
            <select name="anyo" id="anyo">
                <?php

                    for ($i = 1970; $i <= 2023; $i++) { 
                        # code...
                        echo "<option value='" . $i . "'>" . $i . "</option>";
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
            ?>
        </p>
        <label for="texto1">Introduzca una fecha:</label><br/>

<label for="dia">Día: </label>
<select name="dia" id="dia">
    <?php
        for ($i=0; $i < 32; $i++) { 
            # code...
            echo "<option value='" . $i . "'>" . $i . "</option>";

        }
    ?>
</select>

<label for="mes">Mes: </label>
<select name="mes" id="mes">
    <?php
        $mes = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");

        for ($i=0; $i < count($mes); $i++) { 
            # code...
            echo "<option value='" . $mes[$i] . "'>" . $mes[$i] . "</option>";
        }

    ?>
</select>

<label for="anyo">Año: </label>
<select name="anyo" id="anyo">
    <?php

        for ($i = 1970; $i <= 2023; $i++) { 
            # code...
            echo "<option value='" . $i . "'>" . $i . "</option>";
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
?>
</p>
        
        <button type="submit" name="btnCalcular" id="btnCalcular">Calcular</button>
    </form>
    </div>