<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="recogida.php" method="post" enctype="multipart/form-data">
        <h1>Rellena tu CV</h1>

        <label for="nombre">Nombre</label>
        <input type="text" id="nombre" name="nombre"/>
        <br/></br>

        <label for="ape">Apellidos</label>
        <input type="text" id="ape" name="ape"/>
        <br/></br>

        <label for="pass">Contraseña</label>
        <input type="password" id="pass" name="pass"/>
        <br/></br>

        <label for="dni">DNI</label>
        <input type="text" id="dni" name="dni"/>
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
        <textarea id="comentario"></textarea>
        </br></br>      

        <input type="checkbox" id="suscribe"/>
        <label for="suscribe">Suscribirse al boletín de Novedades</label>
        </br></br>

        <input type="submit" value="Guardar Cambios" id="submit" name="submit"/>
        <input type="reset" value="Borrar Cambios"/>

    </form>
</body>
</html>