<h2>No se encuentra el archivo <em>Horario/horarios.txt</em></h2>
<form method="post" action="ejercicio4.php" enctype="multipart/form-data">
<p>
    <label for="fichero">Seleccione un archivo txt (Máx. 1MB)</label>
    <input type="file" name="fichero" id="fichero" accept=".txt">
    <?php
    if(isset($_POST["btnSubir"]) && $error_form)
    {
        if($_FILES["fichero"]["name"]=="")
            echo "<span class='error'>*</span>";
        elseif($_FILES["fichero"]["error"])
            echo "<span class='error'>Error en la subida del archivo al servidor</span>";
        elseif($_FILES["fichero"]["type"]!="text/plain")
            echo "<span class='error'>Error: no has seleccionado un archivo de texto</span>";
        else
            echo "<span class='error'>Error: el archivo seleccionado superior a 1MB</span>";
    }
    ?>
</p>
<p>
    <button type="submit" name="btnSubir">Subir</button>
</p>
</form>