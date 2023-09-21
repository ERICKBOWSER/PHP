<?php
    // Compruebo errores
    if(isset($_POST["submit"])){
        $error_nombre = $_POST["nombre"] == "";
        $error_ape = $_POST["ape"] == "";
        $error_clave = $_POST["pass"] == "";
        $error_sexo = !isset($_POST["sexo"]) == "";
        $error_comentarios = $_POST["comentario"];

        $error_form = $error_nombre || $error_ape || 
        $error_clave || $error_sexo || $error_comentarios;

        if(!$error_form){
            echo "Respuesta";
        }

    }
    if(isset($_POST["submit"]) && !$error_form){
        echo "Respuesta";
    }else{
?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Document</title>
            <style>
                .error{color:red}
            </style>
        </head>
        <body>
            <form action="index.php" method="post" enctype="multipart/form-data">
            <h1>Rellena tu CV</h1>

            <label for="nombre">Nombre</label>
            <input type="text" id="nombre" name="nombre" value="<?php if(isset($_POST["nombre"])) echo $_POST["nombre"];?>"/> 
            <?php
                if(isset($_POST["submit"]) && $error_nombre){ // Hay que preguntar siempre si se ha hecho el submit
                    echo "<span class='error'> Campo vacío </span>";
                }
            ?>
            <br/></br>

            <label for="ape">Apellidos</label>
            <input type="text" id="ape" name="ape" value="<?php if(isset($_POST["ape"])) echo $_POST["ape"];?>"/>
            <?php
                if(isset($_POST["submit"]) && $error_ape){ // Hay que preguntar siempre si se ha hecho el submit
                    echo "<span class='error'> Campo vacío </span>";
                }
            ?>
            <br/></br>

            <label for="pass">Contraseña</label>
            <input type="password" id="pass" name="pass"/>
            <br/></br>

            <label for="sexo">Sexo</label>
            <input type="checkbox" id="hombre" name="sexo"/>
            <label>Hombre</label>
            <input type="checkbox" id="mujer" name="sexo"/>
            <label>Mujer</label>
            </br></br>

            <label>Incluir mi foto:</label>
            <input type="file" id="img" accept="jpg"/>
            </br></br>

            <label>Nacido en:</label>
            <select name="nacido" id = "nacido">
                <option value="malaga">Malaga</option>
                <option value="madrid" selected>Madrid</option>
            </select></br></br>

            <label>comentarios</label>
            <textarea id="comentario" name="comentario"></textarea>
            </br></br>      

            <input type="checkbox" id="suscribe"/>
            <label for="suscribe">Suscribirse al boletín de Novedades</label>
            </br></br>

            <input type="submit" value="Guardar Cambios" id="submit" name="submit"/>
            <input type="reset" value="Borrar Cambios"/>

        </form>
    </body>
    </html>

<?php
    }


?>

