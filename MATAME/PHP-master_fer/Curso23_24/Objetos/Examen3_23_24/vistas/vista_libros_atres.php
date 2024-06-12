<?php
echo "<h3>Listado de los libros</h3>";

if (!isset($_SESSION["n_registros"])) {
    $_SESSION["n_registros"] = 3;
    $_SESSION["buscar"] = "";
}

if (isset($_POST["n_registros"])) {
    $_SESSION["n_registros"] = $_POST["n_registros"];
    $_SESSION["buscar"] = $_POST["buscar"];
    $_SESSION["pag"] = 1;
}

if (!isset($_SESSION["pag"])) {
    $_SESSION["pag"] = 1;
}

if (isset($_POST["btnPagina"])) {
    $_SESSION["pag"] = $_POST["btnPagina"];
}



try {
    $consulta = "select * from libros";
    $sentencia = $conexion->prepare($consulta);
    $sentencia->execute();
} catch (Exception $e) {
    $sentencia = null;
    $conexion = null;
    session_destroy();
    die("<p>No se ha podido realizar la consulta: " . $e->getMessage() . "</p></body></html>");
}

$resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
//$sentencia = null;

foreach ($resultado as $tupla) {
    echo "<p class='libros'>";
    echo "<img src='img/" . $tupla["portada"] . "' alt='imagen libro' title='imagen libro'><br>";
    echo $tupla["titulo"] . " - " . $tupla["precio"] . "€";
    echo "</p>";
}


$n_paginas = ceil($sentencia->rowCount() / $_SESSION["n_registros"]);
$sentencia = null;
if ($n_paginas > 1) {
    echo "<form id='paginas' action='index.php' method='post'>";
    echo "<p>";
    if ($_SESSION["pag"] != 1) {
        echo "<button type='submit' name='btnPagina' value='1'>|<<</button>";
        echo "<button type='submit' name='btnPagina' value='" . ($_SESSION["pag"] - 1) . "'><</button>";
    }

    for ($i = 1; $i <= $n_paginas; $i++) {
        if ($i == $_SESSION["pag"])
            echo "<button disabled type='submit' name='btnPagina' value='" . $i . "'>" . $i . "</button>";
        else
            echo "<button type='submit' name='btnPagina' value='" . $i . "'>" . $i . "</button>";
    }

    if ($_SESSION["pag"] != $n_paginas) {
        echo "<button type='submit' name='btnPagina' value='" . ($_SESSION["pag"] + 1) . "'>></button>";
        echo "<button type='submit' name='btnPagina' value='" . $n_paginas . "'>>>|</button>";
    }

    echo "</p>";
    echo "</form>";
}
