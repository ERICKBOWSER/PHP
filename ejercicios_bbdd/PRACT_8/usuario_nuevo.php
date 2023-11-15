<?php
    if(isset($_POST["btnGuardar"])){
        $errorArchivo = $_FILES["archivo"]["name"] == "" || $_FILES["archivo"]["error"]
            || !getimagesize($_FILES["archivo"]["tmp_name"])
            || $_FILES["archivo"]["size"] > 500 * 1024;
    }

    // Si no hay errores en el archivo
    if(isset($_POST["btnGuardar"]) && !$errorArchivo){
        $nombreNuevo = md5(uniqid(uniqid(), true));
        $arrayNombre = explode("." $_FILES["archivo"]["name"]);
        $ext = "";

        if(count($arrayNombre) > 1){
            $ext = "." . end($arrayNombre);
        }
        $nombreNuevo .= "." . $ext;

        // Mover imagen a la ruta
        @var = move_uploaded_file($_FILES["archivo"]["tmp_name"], "Img/" . $nombreNuevo);
    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>Agregar nuevo usuario</h2>
    <form action="usuario_nuevo.php" method="post">
        <p>
            <label for="nombre">Nombre: </label>
            <input type="text" name="nombre" id="nombre" maxlength="30" value="<?php if(isset($_POST["nombre"])) echo $_POST["nombre"]; ?>">

            
        </p>
        <p>
            <label for="usuario">Usuario: </label>
            <input type="text" name="usuario" id="usuario" maxlength="50" value="<?php  if(isset($_POST["usuario"])) echo $_POST["usuario"];?>" >             

        </p>
        <p>
            <label for="clave">Contraseña: </label>
            <input type="password" name="clave" maxlength="15" id="clave" >
        </p>
        <p>
            <label for="dni">DNI: </label>
            <input type="text" name="dni" id="dni" maxlength="10">

        </p>
        <p>
            <label for="sexo">Sexo: </label>
            <input type="radio" name="sexo" id="hombre" value="Hombre">
            <input type="radio" name="sexo" id="mujer" value="Mujer">
        </p>

        <p>
            <label for="archivo">Incluir mi foto(Max. 500Kb)</label>
            <input type="file" name="archivo" id="archivo" accept="image/*"/>
            <?php
                if(isset($_POST["btnGuardar"]) && $errorArchivo){
                    if($_FILES["archivo"]["name"] != ""){ // Si no esta vacío
                        if($_FILES["archivo"]["error"]){
                            echo "<span class='error'>No se ha podido subir el archivo al servidor</span>"
                        }elseif(!getimagesize($_FILES["archivo"]["tmp_name"])){
                            echo "<span class='error'>No has seleccionado un archivo de tipo imagen</span>"
                        }else{
                            echo "<span class='error'>El archivo seleccionado supera los 500KB</span>";
                        }
                    }
                }
            ?>
        </p>
        <p>
            <button type="submit" name="btnGuardar">Guardar cambios</button>
            <button type="submit" name="atras">Atrás</button>
        </p>
    </form>
</body>
</html>