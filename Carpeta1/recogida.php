<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recogida de datos</title>
</head>
<body>
    <h1>Recogiendo los datos</h1>
    <?php
        /*
        $a[0] = 3;
        $a[1] = 6;
        $a[2] = -1;
        $a[3] = 8;

        for ($i=0; $i < count($a); $i++) { 
            //var_dump($a);

            echo "<p> Número: " . $a[$i]."</p>";
        }
        */

        if(isset($_POST["submit"])){

        echo "<p><strong>Nombre: </strong>" . $_POST["nombre"] . "</p>";

        echo "<p><strong>Apellidos: </strong>" . $_POST["ape"] . "</p>";

        echo "<p><strong>Contraseña: </strong>" . $_POST["pass"] . "</p>";
        
        if(isset($_POST["sexo"])){
            echo "<p><strong>Sexo: </strong>" . $_POST["sexo"] . "</p>";
        }else
            echo "<p><strong>Sexo: </strong>no esta definido</p>";

        echo "<p><strong>Nacido en: </strong>" . $_POST["nacido"] . "</p>";

        echo "<p><strong>Comentario: </strong>" . $_POST["comentario"] . "</p>";

        if (isset($_POST["suscribe"])){
            echo "<p><strong>Suscribirse: </strong> suscrito</p>";
        }else
            echo "<p><strong>Suscribirse: </strong>no esta suscrito</p>";

        }else{
            header("Location: index.php");
        }

    ?>
</body>
</html>