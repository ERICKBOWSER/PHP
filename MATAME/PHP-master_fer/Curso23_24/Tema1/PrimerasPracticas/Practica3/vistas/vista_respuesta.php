<?php
 if(isset($_POST["btenviar"])){

    ?>
        <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recogida</title>
    <style>.tam_imag{width:35%}</style>
</head>

<body>
    <h1>RECOGIDA DE DATOS</h1>
    <?php


    echo "<p><strong>Nombre: </strong>" .$_POST["nombre"]."</p>";
    echo "<p><strong>Apellidos: </strong>" .$_POST["apellido"]."</p>";
    echo "<p><strong>Contraseña: </strong>" .$_POST["contraseña"]."</p>";
    echo "<p><strong>dni: </strong>" .$_POST["dni"]."</p>";
    echo "<p><strong>Sexo: </strong>" .$_POST["sexo"]."</p>";


    

    if($_FILES["archivo"]["name"]!=""){
        $ext="";
        $array_nombre=explode(".",$_FILES["archivo"]["name"]);
        if(count($array_nombre)>1){ //SI NO LLEVA EXTENSION
            $ext=".".end($array_nombre);
        }
        $nombre_nuevo=md5(uniqid(uniqid(),true)).$ext;//Generar numero unico y le concateno la terminacion
        @$var=move_uploaded_file($_FILES["archivo"]["tmp_name"],"images/".$nombre_nuevo);
        if($var){ //LO DEL @$var y esto es porque si no pega un error raro

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
    
    echo "<p><strong>Nacido en: </strong>" .$_POST["nacido"]."</p>";
    echo "<p><strong>Comentarios: </strong>" .$_POST["comentarios"]."</p>";


    if(isset($_POST["subscripcion"])){ //el isset es para decir si ha seleccionado sexo te devuelve true y si no false


        echo "<p><strong>Subscripcion: </strong> Si </p>";

    }else {

        echo "<p><strong>Subscripcion: </strong> No</p>";
    }

    ?>
</body>
</html>

    <?php

    

 }else {

    header("Localtion:index.php");

 }
?>




