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
        if(isset($_POST["submit"])){

        echo "<p><strong>Nombre: </strong>" . $_POST["nombre"] . "</p>";

        echo "<p><strong>Apellidos: </strong>" . $_POST["ape"] . "</p>";

        echo "<p><strong>Contraseña: </strong>" . $_POST["pass"] . "</p>";

        echo "<p><strong>DNI: </strong>" . $_POST["dni"] . "</p>";
        
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

        // Imagenes
        if($_FILES["archivo"]["name"]!=""){

            $ext="";

            $array_nombre=explode(".",$_FILES["archivo"]["name"]);

            if(count($array_nombre)>1){
                $ext=".".end($array_nombre);

            }

            $nombre_nuevo=md5(uniqid(uniqid(),true)).$ext;

            @$var=move_uploaded_file($_FILES["archivo"]["tmp_name"],"images/".$nombre_nuevo);

            if($var){ 
    
                echo "<h3>Informacion de la foto</h3>";
                echo "<p><strong>Nombre: </strong>".$_FILES["archivo"]["name"]."</p>";
                echo "<p><strong>Tipo: </strong>".$_FILES["archivo"]["type"]."</p>";
                echo "<p><strong>Tamaño: </strong>".$_FILES["archivo"]["size"]."</p>";
                echo "<p><strong>Error: </strong>".$_FILES["archivo"]["error"]."</p>";
                echo "<p><strong>Archivo en el temporal del servidor: </strong>".$_FILES["archivo"]["tmp_name"]."</p>";
                echo "<p><img class='tam_imag' src='images/".$nombre_nuevo."' alt='Foto' title='Foto' /></p>";
        
            }else{
                
                echo "<p><strong>Foto:</strong>No se ha podido mover la imagen seleccionada a la carpeta de destino</p>";
            }
        }else{
    
            echo "<p><strong>Foto: </strong>Imagen no seleccionada</p>";
        }

    ?>
</body>
</html>

