<?php
    if(isset($_POST["btnEnviar"]) && $errorArchivo){

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .tamImg{color: red};
    </style>
</head>
<body>
    <h1>Teoría subir ficheros</h1>
    <h2>Datos del archivo subido</h2>

    <?php
        $nombreNuevo = md5(uniqid(uniqid(), true)); // uniqid crea un id único
        $arrayNombre = explode(".", $_FILES["archivo"]["name"]); // explode permite separar una cadena en partes usando un separador que se defina
        $ext = "";

        if(count($arrayNombre) >1){
            $ext = end($arrayNombre);

            $nombreNuevo .= $ext; // El nombre ya fue seperado con el explode

            // Mover archivo
            @var = move_uploaded_file($_FILES["archivo"]["tmp_name"], "img/" . $nombreNuevo);

            if($var){
                echo "<p><strong>Nombre: </strong>" . $_FILES["archivo"]["name"] . "</p>";
                echo "<p><strong>Tipo: </strong>" . $_FILES["archivo"]["type"] . "</p>";
                echo "<p><strong>Tamaño: </strong>" . $_FILES["archivo"]["size"] . "</p>";
                echo "<p><strong>Error: </strong>" . $_FILES["archivo"]["error"] . "</p>";
                echo "<p><strong>Archivo en el temporal del servidor: </strong>" . $_FILES["archivo"]["tmp_name"] . "</p>";
                echo "<p>La imagen ha sido subida con éxito</p>";
                echo "<p><img class = 'tamImg' src='images/" . $nombreNuevo . "' alt = 'Foto' title='Foto'/></p>";


            }else{
                echo "<p> No se ha podido mover la imagen a la carpeta destino en el servidor.";

            }


            echo "<p>Fin</p>";
        }

    ?>
    
</body>
</html>

<?php
    }else{

    }
?>


