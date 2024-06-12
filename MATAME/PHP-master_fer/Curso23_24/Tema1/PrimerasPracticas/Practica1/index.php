<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Rellena tu CV</h1>
    <form action="recogida.php" method="post" enctype="multipart/form-data">
        <p>
            <label for="nombre">Nombre:</label><br>
            <input type="text" name="nombre" id="nombre"><br>
        </p>

        <p>
            <label for="apellido">Apellido:</label><br>
            <input type="text" name="apellido" id="apellido"><br>
        </p>

        <p>
            <label for="contraseña">Contraseña:</label><br>
            <input type="password" name="contraseña" id="contraseña"><br>
        </p>

        <p>
            <label for="dni">DNI:</label><br>
            <input type="text" name="dni" id="dni"><br>
        </p>

        <p>
            <label>Sexo:</label><br>
            <input type="radio" name="sexo" id="hombre" value="Hombre">Hombre<br>
            <input type="radio" name="sexo" id="mujer" value="Mujer">Mujer<br>
        </p>

        <p>
            <label for="foto">Incluir mi foto </label>
            <input type="file" name="foto" id="foto" accept="image/*">
        </p>

        <p>
            <label for="nacido">Nacido en:</label>
            <select id="nacido" name="nacido">
                <option value="Malaga">Malaga</option>
                <option value="Sevilla">Sevilla</option>
                <option value="Jaen" selected>Jaen</option>
            </select>
        </p>

        <p>
            <label for="comentarios">Comentario:</label>
            <textarea id="comentarios" name="comentarios" rows="10" cols="50">Write something here</textarea>
        </p>

    <p>
        <input type="checkbox" name="subscripcion" id="subscripcion" checked />
        <label for="subscripcion">Subscribirse al boletin de Novedades</label><br/>
    </p>

    <p>
        <button type="submit" name="btenviar">Guardar Cambios</button>
        <button type="reset" name="btborrar">Borrar los datos introducidos</button>
    </p>
</form>
</body>
</html>