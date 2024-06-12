<?php
 if(isset($_POST["btenviar"])){

    ?>
        <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RecogidaFormulario</title>
</head>

<body>
    <h1>RECOGIDA DE DATOS DEL FORMULARIO</h1>
    <?php


    echo "<p><strong>Nombre: </strong>" .$_POST["nombre"]."</p>";
    echo "<p><strong>Nacido en: </strong>" .$_POST["nacido"]."</p>";


    if(isset($_POST["sexo"])){ 
        echo "<p><strong>Sexo: </strong>" .$_POST["sexo"]."</p>";

    }else {

        echo "<p><strong>Sexo: </strong> No seleccionado</p>";
    }


    if(isset($_POST["aficiones"])){  //falta aqui para editar lo de aficiones


        echo "<p><strong>Aficiones: </strong> Deporte </p>"; 

    }else {

        echo "<p><strong>Aficiones: </strong> Nada</p>";
    }

    echo "<p><strong>Comentarios: </strong>" .$_POST["comentarios"]."</p>";

    
    
    ?>
</body>
</html>

    <?php

    

 }else {

    header("Localtion:index.php");

 }
?>