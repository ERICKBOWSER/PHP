<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Practica 2</title>
    </head>
    <body>
        <h1>Datos recogidos</h1>

        <?php
        
            // TEXTO NORMAL
            echo "<p><b>El nombre enviado ha sido:</b> " .$_POST["nombre"]." </p>";
            echo "<p><b>Ha nacido en:</b> " .$_POST["nacimiento"]." </p>";

            // SEXO ELECCION POSIBLE VACIO
            if (isset($_POST["sexo"])) {
                echo "<p><b>El sexo es:</b> " .$_POST["sexo"]." </p>";
            }else{
                echo "<p><b>El sexo es:</b> Vacio </p>";
            }

            // AFICIONES ESCOGIDAS DEPENDIENDO DE CADA ELECCION
            $deporte = false;
            $lectura = false;
            $otros = false;
            
            if (isset($_POST["deportes"])) {
                $deporte = true;
            }
            if (isset($_POST["lectura"])) {
                $lectura = true;
            }
            if (isset($_POST["otros"])) {
                $otros = true;
            }
            
            if ($deporte && $lectura && $otros) {
                echo "<b>Las aficiones seleccionadas han sido:</b>";
                echo "<ol><li>Deportes</li><li>Lectura</li><li>Otros</li></ol>";
            }else if ($deporte && $lectura) {
                echo "<b>Las aficiones seleccionadas han sido:</b>";
                echo "<ol><li>Deportes</li><li>Lectura</li></ol>";
            }else if ($deporte && $otros) {
                echo "<b>Las aficiones seleccionadas han sido:</b>";
                echo "<ol><li>Deportes</li><li>Otros</li></ol>";
            }else if ($lectura && $otros) {
                echo "<b>Las aficiones seleccionadas han sido:</b>";
                echo "<ol><li>Lectura</li><li>Otros</li></ol>";
            }else if ($deporte) {
                echo "<b>La afición seleccionada ha sido:</b>";
                echo "<ol><li>Deportes</li></ol>";
            }else if ($lectura) {
                echo "<b>La afición seleccionada ha sido:</b>";
                echo "<ol><li>Lectura</li></ol>";
            }else if ($otros) {
                echo "<b>La afición seleccionada ha sido:</b>";
                echo "<ol><li>Otros</li></ol>";
            }else{
                echo "<b>No has seleccionado ninguna afición</b>";
            }


            if ($_POST["comentario"] != "") {
                echo "<p><b>El comentario enviado ha sido: </b>" .$_POST["comentario"]."</p>";
            }else{
                echo "<p><b>No has hecho ningún comentario</b></p>";
            }
            
        ?>

    </body>
</html>