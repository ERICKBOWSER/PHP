<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conversor de Números</title>
    <style>.error {color: red;}</style>
</head>
<body>

<?php

    $errorFormu = false; 

    // Si los campos están vacíos o no contienen la longitud adecuada
    if (isset($_POST["convertir"])) {
        $entrada = $_POST['numeros'];
        $errorPrimera = $entrada === "" || !preg_match('/^[\d\s,.]+$/', $entrada);
        $entrada = normalizarNumeros($entrada);

        // Comprobar si hay errores
        if ($errorPrimera) {
            $errorFormu = true; 
        }
    }

    function normalizarNumeros($entrada) {
        // Reemplazar comas por puntos
        $entrada = str_replace(',', '.', $entrada);
        // Eliminar espacios en blanco adicionales
        $entrada = preg_replace('/\s+/', ' ', $entrada);
        return $entrada;
    }
?>

<form action="Ejercicio7.php" method="post">
    <div style="background-color:lightblue; border:solid; padding:5px;">
        <h1 style="text-align:center">Unifica separador decimal - Formulario</h1>
        <p>Escribe varios numeros separados por espacios y unificare el separador decimal a puntos</p>
        <p>
            <label for="numeros">Números:</label>
            <input type="text" name="numeros" id="numeros" value="<?php if(isset($entrada)) echo $entrada; ?>"/>
            <?php
                 if (isset($_POST["convertir"]) && $errorFormu) {
                    echo "<span class='error'>*Introduce un numero correcto*</span>";
                 }
            ?>
        </p>
        <p>
            <button type="submit" name="convertir">Convertir</button>
        </p>
    </div>

    <?php
        if (isset($_POST["convertir"]) && !$errorFormu) {
            echo '<div style="background-color:lightgreen; border:solid; margin-top:10px; padding:5px;">';
            echo '<h1 style="text-align:center">Unifica separador decimal - Resultado</h1>';
            echo '<p>Números normalizados: ' . $entrada . '</p>';
            echo '</div>';
        }
    ?>
</form>
</body>
</html>
