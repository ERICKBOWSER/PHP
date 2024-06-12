<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conversor de Números Árabes a Romanos</title>
    <style>.error{color:red;}</style>
</head>
<body>

        <?php

            const VALOR = array("M" => 1000, "D" => 500, "C" => 100, "L" => 50, "X" => 10, "V" => 5, "I" => 1);

            function arabes_a_romanos($numero) {
                $resultado = '';
                foreach (VALOR as $romano => $valor) {
                    while ($numero >= $valor) {
                        $resultado .= $romano;
                        $numero -= $valor;
                    }
                }
                return $resultado;
            }

            // Si el formulario se envía
            if (isset($_POST["convertir"])) {
                $numero = intval($_POST['arabe']);
                $error = false;

                if ($numero <= 0 || $numero >= 5000) {
                    $error = true;
                }

                if (!$error) {
                    $resultado_romano = arabes_a_romanos($numero);
                }
            }

        ?>

    <form action="Ejercicio4.php" method="post">

        <div style="background-color:lightblue; border:solid; padding:5px;">

            <h1 style="text-align:center">Árabes a Romanos - Formulario</h1>

            <p>Ingresa un número árabe (menor a 5000) y lo convertiré en número romano:</p>
            <p>
                <label for="arabe">Número Árabe:</label>
                <input type="number" name="arabe" id="arabe" value="<?php if(isset($_POST['arabe'])) echo $_POST['arabe']; ?>"/>
                <?php
                    if (isset($_POST["convertir"])) {
                        if ($error) {
                            echo "<span class='error'>* Ingresa un número árabe válido (menor a 5000).</span>";
                        }
                    }
                ?>
            </p>

            <p>
                <button type="submit" name="convertir">Convertir</button>
            </p>

        </div>

        <?php
            if (isset($_POST["convertir"]) && !$error) {
                echo '<div style="background-color:lightgreen; border:solid; margin-top:10px; padding:5px;">';
                echo '<h1 style="text-align:center">>Árabes a Romanos - Resultado</h1>';
                echo '<p>' . $numero . ' en números romanos es: ' . $resultado_romano . '</p>';
                echo '</div>';
            }
        ?>

    </form>
</body>
</html>
