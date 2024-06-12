<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Practica 2</title>
    </head>
    <body>
        <h1>Estos son los datos enviados</h1>


        <?php
        
            echo "<p><b>El nombre enviado ha sido:</b> " .$_POST["nombre"]." </p>";
            echo "<p><b>Ha nacido en:</b> " .$_POST["nacimiento"]." </p>";

            if (isset($_POST["sexo"])) {
                echo "<p><b>El sexo es:</b> " .$_POST["sexo"]." </p>";
            }else{
                echo "<p><b>El sexo es:</b> Vacio </p>";
            }

            //AFICIONES
            if(!isset($_POST["aficiones"])){

                echo "<p><b>No has selccionada ninguna aficion</b></p>";

            }elseif(count($_POST["aficiones"])==1){

                echo "<p><b>La aficion seleccionada ha sido:</b></p>";
                echo "<ol>";
                echo "<li>".$_POST["aficiones"][0]."</li>";
                echo "</ol>";
            }else{

                echo "<p><b>Las aficiones seleccionadas han sido:</b></p>";
                echo "<ol>"
                for ($i=0; $i < count($_POST["aficiones"]); $i++) { 
                    
                    echo "<li>".$_POST["aficiones"][$i]."</li>";

                }
                echo "</ol>";
            }


            if ($_POST["comentario"] != "") {
                echo "<p><b>El comentario enviado ha sido: </b>" .$_POST["comentario"]."</p>";
            }else{
                echo "<p><b>No has hecho ningún comentario</b></p>";
            }
            
        ?>

    </body>
</html>