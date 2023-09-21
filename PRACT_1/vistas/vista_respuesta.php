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
            <?php
                if(isset($_POST["submit"]) && $error_clave){ // Hay que preguntar siempre si se ha hecho el submit
                    echo "<span class='error'> Campo vacío </span>";
                }
            ?>
            <br/></br>

            <label for="sexo">Sexo</label>
            <?php
                if(isset($_POST["submit"]) && $error_sexo){ // Hay que preguntar siempre si se ha hecho el submit
                    echo "<span class='error'>Debes seleccionar un sexo</span>";
                }
            ?>
            <input type="radio" id="hombre" name="sexo" value="hombre" <?php if(isset($_POST["sexo"]) && $_POST["sexo"] == "hombre") echo "checked";?>/>
            <label>Hombre</label>
            <input type="radio" id="mujer" name="sexo" value="mujer" <?php if(isset($_POST["sexo"]) && $_POST["sexo"] == "mujer") echo "checked"; ?>/>
            <label>Mujer</label>
            </br></br>

            <label>Incluir mi foto:</label>
            <input type="file" id="img" accept="jpg"/>
            </br></br>

            <label>Nacido en:</label>
            <select name="nacido" id = "nacido">
                <option value="malaga" <?php if(!isset($_POST["nacido"]) || (isset($_POST["nacido"]) && $_POST["nacido"]=="malaga")) echo "selected";?>>Malaga</option>
                <option value="madrid" <?php if(!isset($_POST["nacido"]) || (isset($_POST["nacido"]) && $_POST["nacido"]=="madrid")) echo "selected";?>>Madrid</option>
            </select></br></br>

            <label>comentarios</label>
            <textarea id="comentario" name="comentario">
                <?php if(isset($_POST["ape"])) echo $_POST["ape"];?>
            </textarea>
            <?php
                if(isset($_POST["submit"]) && $error_comentarios){ // Hay que preguntar siempre si se ha hecho el submit
                    echo "<span class='error'> Campo vacío </span>";
                }
            ?>
            </br></br>      

            <input type="checkbox" id="suscribe"/>
            <label for="suscribe">Suscribirse al boletín de Novedades</label>
            </br></br>

            <input type="submit" value="Guardar Cambios" id="submit" name="submit"/>
            <input type="reset" value="Borrar Cambios"/>

        </form>
    </body>
    </html>