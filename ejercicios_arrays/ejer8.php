<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        $usuario = array("Pedro", "Ismael", "Sonia", "Clara", "Susana", "Alfonso", "Teresa");

        echo "<h2>Usuarios</h2>";
        echo "<ul>";

        for ($i=0; $i < count($usuario); $i++) { 
            # code...
            echo "<li>" . $usuario[$i] . "</li>";
        }

        echo "</ul>";

    ?>
</body>
</html>