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
    <h1>Esta es mi super página</h1>
    <form method="post" action="index.php">
        <p>
            <label for="nombre">Nombre: </label>
            <input type="text" id="nombre" name="nombre" value="<?php if(isset($_POST["nombre"])) echo $_POST["nombre"];?>"/> <!-- El value no puede tener espacio ya que se va añadiendo un espacio cada vez que se recarga la página-->
            <?php
                if(isset($_POST["submit"]) && $error_nombre){
                    echo "<span class='error'>Campo vacio</span>";
                }
            ?>
        </p>
        <p>
            <label for="nacido">Nacido en: </label>
            <select name="nacido">
                <option value="Málaga" <?php if(isset($_POST['nacido']) && $_POST["nacido"] == "Málaga") echo "selected";?>>Málaga</option>
                <option value="Madrid" <?php if(isset($_POST['nacido']) && $_POST["nacido"] == "Marbella") echo "selected";?>>Madrid</option>
                <option value="Barcelona" <?php if(isset($_POST['nacido']) && $_POST["nacido"] == "Barcelona") echo "selected";?>>Barcelona</option>
            </select>
        </p>
        <p>
            <label for="sexo">Sexo: </label>
            <label for="hombre">Hombre </label>
            <input type="checkbox" name="hombre" id="sexo" value="hombre"/>
            <label for="mujer">Mujer </label>
            <input type="checkbox" name="mujer" id="sexo"/>
            <?php
                if(isset($_POST["submit"]) && $error_nombre){
                    echo "<span class='error'>Debes seleccionar un sexo</span>";
                }
            ?>
        </p>
        <p>
            <label for="aficiones">Aficiones: </label>
            <label for="deportes">Deportes </label>
            <input type="radio" name="aficiones[]" id="deportes" value="Deportes" <?php if(isset($_POST["aficiones"]) && enArray("Deportes", $_POST["aficiones"])) echo "checked";?>/> <!-- Tiene que ir entre corchetes para guardarlo como array ya que recibe varios parametros -->

            <label for="lectura">Lectura </label>
            <input type="radio" name="aficiones[]" id="lectura" value="Lectura" <?php if(isset($_POST["aficiones"]) && enArray("Lectura", $_POST["aficiones"])) echo "checked";?>/>

            <label for="otros">Otros </label>
            <input type="radio" name="aficiones[]" id="otros" value="Otros" <?php if(isset($_POST["aficiones"]) && enArray("Otros", $_POST["aficiones"])) echo "checked";?>/>
        </p>

        <p>
            <label for="comentario">Comentario: </label>
            <textarea name="comentario" id="comentario" <?php if(isset($_POST["comentario"])) echo $_POST["comentario"];?>></textarea>
        </p>

        <p>
            <input type="submit" name="enviar" id="enviar" value="Enviar"/>
        </p>


    </form>
    
</body>
</html>