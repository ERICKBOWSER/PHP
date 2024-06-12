<?php
 if(isset($_POST["btenviar"])){

    ?>
        <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recogida</title>
</head>

<body>
    <h1>RECOGIDA DE DATOS</h1>
    <?php


    echo "<p><strong>Nombre: </strong>" .$_POST["nombre"]."</p>";
    echo "<p><strong>Apellidos: </strong>" .$_POST["apellido"]."</p>";
    echo "<p><strong>Contraseña: </strong>" .$_POST["contraseña"]."</p>";
    echo "<p><strong>DNI: </strong>" .$_POST["dni"]."</p>";
    


    if(isset($_POST["sexo"])){ //el isset es para decir si ha seleccionado sexo te devuelve true y si no false

        echo "<p><strong>Sexo: </strong>" .$_POST["sexo"]."</p>";

    }else {

        echo "<p><strong>Sexo: </strong> No seleccionado</p>";
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




