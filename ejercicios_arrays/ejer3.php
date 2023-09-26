<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Meses</h1>
    <?php
        $meses = array("enero" => 9, "febrero" => 12, "marzo" => 0, "abril" => 17);

        foreach($meses as $mes => $valor){
            if($valor != 0){
                echo "<p>" . $mes . ": " . $valor. "</p>";
            }
        }        
    ?>
</body>
</html>