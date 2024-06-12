<h2>Agregar Nueva Pelicula</h2>
    <form action="index.php" method="post" enctype="multipart/form-data">
        <p>
            <label for="titulo">Titulo de la pelicula</label><br/>
            <input type="text" name="titulo" id="titulo" maxlength="15" value="<?php if(isset($_POST["titulo"])) echo $_POST["titulo"];?>"/>
            <?php
            if(isset($_POST["btnContNueva"])&& $error_titulo)
            {
                if($_POST["titulo"]=="")
                    echo "<span class='error'> Campo vacío </span>";
                elseif(strlen($_POST["titulo"])>15)
                    echo "<span class='error'> Has tecleado más de 15 caracteres</span>";
                else 
                    echo "<span class='error'>Titulo repetido</span>";
            }
            ?>
        </p>
        <p>
            <label for="director">Director de la pelicula</label><br/>
            <input type="text" name="director" id="director" maxlength="20" value="<?php if(isset($_POST["director"])) echo $_POST["director"];?>"/>
            <?php
            if(isset($_POST["btnContNueva"])&& $error_director)
            {
                if($_POST["director"]=="")
                    echo "<span class='error'> Campo vacío </span>";
                else
                    echo "<span class='error'> Has tecleado más de 20 caracteres</span>";
            }
                
            ?>
        </p>
        <p>
            <label for="sinopsis">Sinopsis de la pelicula:</label><br/>
            <textarea type="text" name="sinopsis" id="sinopsis" rows="15" cols="40"><?php if(isset($_POST["sinopsis"])) echo $_POST["sinopsis"];?></textarea>
            <?php
            if(isset($_POST["btnContNueva"]) && $error_sinopsis)
            {
                if($_POST["sinopsis"]=="")
                    echo "<span class='error'> Campo vacío </span>";
            }
            ?>
        </p>
        <p>
            <label for="tematica">Tematica de la pelicula:</label><br/>
            <input type="text" maxlength="15" name="tematica" id="tematica" value="<?php if(isset($_POST["tematica"])) echo $_POST["tematica"];?>"/>
            <?php
             if(isset($_POST["btnContNueva"])&& $error_tematica)
             {
                 if($_POST["tematica"]=="")
                     echo "<span class='error'> Campo vacío </span>";
                 elseif(strlen($_POST["tematica"])>15)
                     echo "<span class='error'> Has tecleado más de 15 caracteres</span>";
             }
                
            ?>
        </p>

        <p>
            <label for="caratula">Añadir caratula de la pelicula</label>
            <input type="file" name="caratula" id="caratula" accept="image/*"/>
            <?php
            if(isset($_POST["btnContNueva"]) && $error_caratula)
            {
                if($_FILES["caratula"]["error"])
                    echo "<span class='error'> No se ha podido subir el archivo al servidor</span>";
                elseif(!getimagesize( $_FILES["caratula"]["tmp_name"]))
                    echo "<span class='error'> No has seleccionado un archivo de tipo imagen</span>";
                elseif(!tiene_extension($_FILES["caratula"]["name"]))
                    echo "<span class='error'> Has seleccionado un archivo imagen sin extensión</span>";
                else
                    echo "<span class='error'> El archivo seleccionado supera los 500KB</span>";/*QUITAR ESTO SI SALE ERROR*/ 
            }
            ?>
        </p>
        
        
        <p>
            <button type="submit" name="btnContNueva">Crear Nueva Pelicula</button>
            <button type="submit" >Atras</button>
        </p>
        
    </form>