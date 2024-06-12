<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=ç, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <?php

function archivoATabla($archivo) {
    if (!file_exists($archivo)) {
        return "El archivo no existe.";
    }
    $abrirarchivo = fopen($archivo, 'r');
    echo '<table border="1">';
    while (($line = fgets($abrirarchivo)) !== false) {
        $datos = explode(',', $line);
        echo '<tr>';
        foreach ($datos as $dato) {
            echo '<td>' . trim($dato) . '</td>';
        }
        echo '</tr>';
    }
    fclose($abrirarchivo);
    echo '</table>';
}
$nombreArchivo = 'prueba.txt'; 
archivoATabla($nombreArchivo);
    ?>
    
</body>
</html>