<?php 
    if(isset($_POST["btnGuardar"])){

        $errorUsuario = $_POST["usuario"] == "";
        $errorClave = $_POST["contrasenia"] == "";
        $errorNombre = $_POST["nombre"] == "";
        $sexo = $_POST["sexo"] == "";


        $errorImage = $_FILES["foto"]["name"] == ""
        || $_FILES["foto"]["error"]
        || !getimagesize($_FILES["foto"]["tmp_name"]) /* Comprobamos si es una imagen */
        || $_FILES["foto"]["size"] > 500 * 1024;

        /* getimagesize() si se le pasa un archivo que no es una imagen duvuelve false */
    }

    if(isset($_POST["btnGuardar"]) && !$errorImage){


?>


<?php
    }else{

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="index.php" method="post" enctype="multipart/form-data">
    <h1>Rellena tu CV</h1>
    
    <label for="usuario">Usuario:</label><br>
    <input type="text" name="usuario" id="usuario" value="<?php if(isset($_POST["usuario"])) echo $_POST["usuario"];?>">
    <br>
    <?php
    if(isset($_POST["btnGuardar"]) && $errorUsuario){
        if($_POST["usuario"] == ""){
            echo "<p class='error'>Debes rellenar el usuario</p>";
        }
    }


    ?>

    <label for="nombre">Nombre:</label><br>
    <input type="text" name="nombre" id="nombre" value="<?php if(isset($_POST["nombre"])) echo $_POST["nombre"];?>">

    <?php 
        if(isset($_POST["btnGuardar"]) && $errorNombre){
            if($_POST["nombre"] == ""){
                echo "<p class='error'>Debes rellenar el nombre</p>";
            }else{
                echo "<p class='error'>Has tecleado más de 20 caracteres</p>";
            }
        }

    ?>
    <br>

    <label for="contrasenia">Contraseña:</label><br>
    <input type="text" name="contrasenia" id="contrasenia">
    <?php
        if(isset($_POST["btnGuardar"]) && $errorClave){
            if($_POST["contrasenia"] == ""){
                echo "<p class='error'>Debes rellenar la contraseña</p>";
            }else{
                echo "<p class='error'>Has tecleado más de 15 caracteres</p>";
            }
        }
    ?>
    <br>

    <label for="dni">DNI:</label><br>
    <input type="text" name="dni" id="dni" value="<?php if(isset($_POST["dni"])) echo $_POST["dni"];?>">
    <br>

    <label for="sexo">Sexo</label><br>
    <input type="radio" <?php if($sexo == "hombre") echo "checked";?> name="sexo" id="hombre" value="hombre">
    <input type="radio" <?php if($sexo == "mujer") echo "checked";?> name="sexo" id="mujer" value="mujer">
    <br>

    <label for="foto">Incluir mi foto (Max 500KB)</label>
    <input type="file" name="foto" id="foto" accept="image/*">
    <?php
    if(isset($_POST["btnGuardar"]) && $errorImage){
        if($_FILES["foto"]["name"] != ""){
            if($_FILES["foto"]["error"]){
                echo "<p class='error'>No se eligió archivo</p>";
            }elseif(!getimagesize($_FILES["foto"]["tmp_name"])){
                echo "<p class='error'>No has seleccionado un archivo tipo imagen</p>";
            }else{
                echo "<p class='error'>El archivo seleccionado supera los 200Kb</p>";
            }
        }
    }

    ?>
    <br>
    
    <input type="checkbox" name="boletin" id="boletin" value="boletin">
    <label for="boletin">Suscribirme al boletin de novedades</label>
    <br>

    <input type="submit" name="btnGuardar" id="guardar" value="Guardar Cambios">
    <input type="reset" name="btnBorrar" id="borrar" value="Borrar los datos introducidos">



    </form>    
</body>
</html>
<?php
    }
?>