<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario</title>
</head>
<body>
    <h1>Esta es mi super pagina</h1>
    <form action="recogidaFormulario.php" method="post" enctype="multipart/form-data">
        <p>
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" id="nombre"><br>
        </p>


        <p>
            <label for="nacido">Nacido en:</label>
            <select id="nacido" name="nacido">
                <option value="Malaga" selected>Malaga</option>
                <option value="Sevilla">Sevilla</option>
                <option value="Jaen">Jaen</option>
            </select>
        </p>

        <p>
            <label>Sexo:</label>
            <input type="radio" name="sexo" id="hombre" value="Hombre"><label>Hombre</label>
            <input type="radio" name="sexo" id="mujer" value="Mujer"><label>Mujer</label>
        </p>


        <p>
            <label>Aficiones:</label>
            <label>Deportes</label><input type="checkbox" name="aficiones" id="deportes" value="deportes">
            <label>Lectura</label><input type="checkbox" name="aficiones" id="lectura" value="lectura">
            <label>Otros</label><input type="checkbox" name="aficiones" id="otros" value="otros">
        </p>


        <p>
            <label for="comentarios">Comentarios:</label>
            <textarea id="comentarios" name="comentarios"></textarea>
        </p>

        <p>
            <button type="submit" name="btenviar">Enviar</button>
        </p>
</form>
</body>
</html>