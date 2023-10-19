<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <?php

    @$fd = fopen("http://dwese.icarosproject.com/PHP/datos_ficheros.txt", "r");

    if(!$fd){
        die("<p>No se ha podido abrir el archivo</p>");
    }

    $primeraLinea = fgets($fd);

    while($linea = fgets($fd)){
        $datosLinea = explode("\t", $linea);
        $datosPrimeraColumna = explode(",", $datosLinea[0]);
        $paises[] = $datosPrimeraColumna[2];

        if(isset($_POST["pais"]) && $_POST["pais"] == $datosPrimeraColumna[2]){
            $datosPaisSeleccionado = $datosLinea;
        }


    }

    fclose($fd);
    ?>
    <form action="ejer6.php" method="post">
        <p>
            <label for="pais"> Seleccione un pais</label>
            <select name="pais" id="pais">
            <?php
                for($i = 0; $i < count($paises); $i++){
                    if(isset($_POST["pais"]) && $_POST["pais"] == $paises[$i]){
                        echo "<option value='" . $paises[$i] . "'>" . $paises[$i] . "</option>";
                    }else{
                        echo "<option value='" . $paises[$i] . "'>" . $paises[$i] . "</option>";
                    }
                }
            ?>
            </select>
        </p>
        <p>
            <button type="submit" name="btnBuscar">Buscar</button>

        </p>

    </form>
    <?php   
        if(isset($_POST["btnBuscar"])){
            echo "<h2>PIB per cápita de " . $_POST["pais"] . "</h2>";
            $datosPrimeraLinea = explode("\t", $primeraLinea);

            $nAnios = count($datosPrimeraLinea) - 1;

            echo "<table>";
            echo "<tr>";
            for($i = 1; $i < $nAnios; $i++){
                echo "<th>". $datosPrimeraLinea[$i] ."</th>";
            }
            echo "</tr>";
            echo "<tr>";
            for($i = 1; $i < $nAnios; $i++){
                if(isset($datosPaisSeleccionado[$i])){
                    echo "<td>". $datosPaisSeleccionado[$i] ."</td>";
                }else{
                    echo "<td></td>";
                }
            }
            echo "</tr>";

            echo "</table>";

        }
    ?>
</body>
</html>