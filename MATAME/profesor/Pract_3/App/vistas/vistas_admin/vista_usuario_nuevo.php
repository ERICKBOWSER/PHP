<?php
if(isset($_POST["btnBorrarNuevo"]))
unset($_POST);
?>
<h3>Nuevo Usuario</h3>
<form action="index.php" method="post" enctype="multipart/form-data">
<p>
<label for="usuario">Usuario: </label><br>
<input type="text" id="usuario" name="usuario" value="<?php if(isset($_POST["usuario"])) echo $_POST["usuario"];?>" placeholder="Usuario...">
<?php
if(isset($_POST["btnContNuevo"])&& $error_usuario)
{
    if($_POST["usuario"]=="")
        echo "<span class='error'> Campo vacío</span>";
    else
        echo "<span class='error'> Usuario repetido</span>";
}
    
?>
</p>
<p>
<label for="nombre">Nombre: </label><br>
<input type="text" id="nombre" name="nombre" value="<?php if(isset($_POST["nombre"])) echo $_POST["nombre"];?>" placeholder="Nombre...">
<?php
if(isset($_POST["btnContNuevo"])&& $error_nombre)
    echo "<span class='error'> Campo vacío</span>";
?>
</p>
<p>
<label for="clave">Contraseña: </label><br>
<input type="password" id="clave" name="clave" placeholder="Contraseña...">
<?php
if(isset($_POST["btnContNuevo"])&& $error_clave)
    echo "<span class='error'> Campo vacío</span>";
?>
</p>
<p>
<label for="dni">DNI: </label><br>
<input type="text" id="dni" name="dni" value="<?php if(isset($_POST["dni"])) echo $_POST["dni"];?>" placeholder="DNI: 11223344Z">
<?php
if(isset($_POST["btnContNuevo"])&& $error_dni)
{
    if($_POST["dni"]=="")
        echo "<span class='error'> Campo vacío</span>";
    else if(!dni_bien_escrito($_POST["dni"]))
        echo "<span class='error'> DNI no está bien escrito</span>";
    else if(!dni_valido($_POST["dni"]))
        echo "<span class='error'> DNI no es válido</span>";
    else
        echo "<span class='error'> DNI repetido</span>";
}
?>
</p>
<p>
<label>Sexo: </label><br>
<input type="radio" id="hombre" name="sexo" value="hombre" <?php if(!isset($_POST["sexo"]) || (isset($_POST["sexo"]) && $_POST["sexo"]=="hombre")) echo "checked";?>>
<label for="hombre">Hombre: </label><br>
<input type="radio" id="mujer" name="sexo" value="mujer" <?php if(isset($_POST["sexo"]) && $_POST["sexo"]=="mujer") echo "checked";?>>
<label for="mujer">Mujer: </label><br>
</p>
<p>
<label for="foto">Incluir mi foto (Máx. 500 KB)</label>
<input type="file" name="foto" id="foto" accept="image/*">
<?php
if(isset($_POST["btnContNuevo"])&& $error_foto)
{
    if($_FILES["foto"]["error"])
        echo "<span class='error'> Error en la subida del fichero al servidor </span>";
    else if (!explode(".",$_FILES["foto"]["name"]))
        echo "<span class='error'> El fichero subido debe tener extensión </span>";
    else if (! getimagesize($_FILES["foto"]["tmp_name"]))
        echo "<span class='error'> El fichero subido debe ser una imagen</span>";
    else
        echo "<span class='error'> El tamaño del fichero no debe superar los 500 KB</span>";
}
?>
</p>
<p>
<input type="checkbox" id="subsc" name="subscripcion" <?php if(isset($_POST["subscripcion"])) echo "checked";?>>
<label for="subsc">Suscribirme al boletín de novedades: </label><br>
</p>
<p>
<button type="submit" name="btnContNuevo">Guardar Cambios</button>
<button type="submit" name="btnBorrarNuevo">Borrar los datos introducidos</button>
</p>
</form>

