<?php 
if(isset($_POST["btnAgregar"]))
{
    $error_referencia=$_POST["referencia"]==""||!is_numeric($_POST["referencia"])||$_POST["referencia"]<0;
    if(!$error_referencia)
    {
        $error_referencia=repetido($conexion,"libros","referencia",$_POST["referencia"]);
        if(is_string($error_referencia))
        {
            session_destroy();
            mysqli_close($conexion);
            die(error_page("Examen3 Curso 23-24","<h1>Librería</h1><p>Error en la consulta: ".$error_referencia."</p>"));
        }
    }
    $error_titulo=$_POST["titulo"]=="";
    $error_autor=$_POST["autor"]=="";
    $error_descripcion=$_POST["descripcion"]=="";
    $error_precio=$_POST["precio"]==""||!is_numeric($_POST["precio"])||$_POST["precio"]<=0;
    $array_nombre=explode(".",$_FILES["portada"]["name"]);
    $error_portada=$_FILES["portada"]["name"]!="" && ($_FILES["portada"]["error"] || !$array_nombre || !getimagesize($_FILES["portada"]["tmp_name"]) || $_FILES["portada"]["size"]>750*1024 );
    $error_form=$error_referencia||$error_titulo||$error_autor||$error_descripcion||$error_precio||$error_portada;
    if(!$error_form)
    {
        
        try{
            $consulta="insert into libros(referencia, titulo, autor,descripcion,precio) values('".$_POST["referencia"]."','".$_POST["titulo"]."','".$_POST["autor"]."','".$_POST["descripcion"]."','".$_POST["precio"]."')";
            mysqli_query($conexion,$consulta);
        }
        catch(Exception $e)
        {
            session_destroy();
            mysqli_close($conexion);
            die(error_page("Examen3 Curso 23-24","<h1>Librería</h1><p>Error en la consulta: ".$e->getMessage()."</p>"));
        }

        $_SESSION["accion"]="Libro agregado con éxito";
        if($_FILES["portada"]["name"]!="")
        {
            $ext=end($array_nombre);
            $nombre_nuevo="img".$_POST["referencia"].".".$ext;
            @$var=move_uploaded_file($_FILES["portada"]["tmp_name"],"../img/".$nombre_nuevo);
            if($var)
            {
                try{
                    $consulta="update libros set portada='".$nombre_nuevo."' where referencia='".$_POST["referencia"]."'";
                    mysqli_query($conexion,$consulta);
                }
                catch(Exception $e)
                {
                    unlink("../img/".$nombre_nuevo);
                    session_destroy();
                    mysqli_close($conexion);
                    die(error_page("Examen3 Curso 23-24","<h1>Librería</h1><p>Error en la consulta: ".$e->getMessage()."</p>"));
                }
            }
            else
                $_SESSION["accion"]="Libro agregado con éxito pero con la imagen por defecto por no poder mover la imagen subida a la carpeta destino";
        }

        mysqli_close($conexion);
        header("Location:gest_libros.php");
        exit;
    }
}


if(isset($_POST["btnBorrar"]))
{
    $_SESSION["accion"]="EL libro con referencia ".$_POST["btnBorrar"]." se ha borrado con éxito";
    mysqli_close($conexion);
    header("Location:gest_libros.php");
    exit;
}

if(isset($_POST["btnEditar"]))
{
    $_SESSION["accion"]="EL libro con referencia ".$_POST["btnEditar"]." se ha editado con éxito";
    mysqli_close($conexion);
    header("Location:gest_libros.php");
    exit;
}
?>
<!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Examen3 Curso 23-24</title>
        <style>
            .enlinea{display:inline}
            .enlace{border:none;background:none;text-decoration:underline;color:blue;cursor:pointer}
            table{width:80%;margin:0 auto;text-align:center;border-collapse:collapse}
            table,th,td{border:1px solid black}
            th{background-color:#CCC}
            .mensaje{font-size:1.25em;color:blue}
            label{width:100px;float:left}
            .error{color:red}
        </style>
    </head>
    <body>
        <h1>Librería</h1>
        <div>Bienvenido <strong><?php echo $datos_usuario_logueado["lector"];?></strong> - 
            <form class='enlinea' action="gest_libros.php" method="post">
                <button class='enlace' type="submit" name="btnSalir">Salir</button>
            </form>
        </div>
        <?php
        if(isset($_SESSION["accion"]))
        {
            echo "<p class='mensaje'>".$_SESSION["accion"]."</p>";
            unset($_SESSION["accion"]);
        }

        echo "<h3>Listado de los libros</h3>";
        

        try{
        
            $resultado=mysqli_query($conexion,"select * from libros");
        }
        catch(Exception $e)
        {
            session_destroy();
            mysqli_close($conexion);
            die("<p>No he podido realizar la consulta: ".$e->getMessage()."</p></body></html>");
        }
        
        echo "<table>";
        echo "<tr><th>Ref</th><th>Título</th><th>Acción</th></tr>";
        while($tupla=mysqli_fetch_assoc($resultado))
        {
            echo "<tr>";
            echo "<td>".$tupla["referencia"]."</td>";
            echo "<td>".$tupla["autor"]."</td>";
            echo "<td><form action='gest_libros.php' method='post'><button class='enlace' name='btnBorrar' value='".$tupla["referencia"]."'>Borrar</button> - <button class='enlace' name='btnEditar' value='".$tupla["referencia"]."'>Editar</button></form></td>";
            echo "</tr>";
        }
        echo "</table>";
        mysqli_free_result($resultado);
        ?>
        <h3>Agregar un libro nuevo</h3>
        <form action="gest_libros.php" method="post" enctype="multipart/form-data">
            <p>
                <label for="referencia">Referencia:</label>
                <input type="text" name="referencia" id="referencia" value="<?php if(isset($_POST["referencia"])) echo $_POST["referencia"];?>">
                <?php
                if(isset($_POST["referencia"])&& $error_referencia)
                {
                    if($_POST["referencia"]=="")
                        echo "<span class='error'> Campo Vacío</span>";
                    elseif(!is_numeric($_POST["referencia"])||$_POST["referencia"]<0)
                        echo "<span class='error'> Referencia no es un número mayor o igual que cero</span>";
                    else
                        echo "<span class='error'> Referencia repetida</span>";
                }
                ?>
            </p>
            <p>
                <label for="titulo">Título:</label>
                <input type="text" name="titulo" id="titulo" value="<?php if(isset($_POST["titulo"])) echo $_POST["titulo"];?>">
                <?php
                if(isset($_POST["titulo"])&& $error_titulo)
                    echo "<span class='error'> Campo Vacío</span>";
                 ?>
            </p>
            <p>
                <label for="autor">Autor:</label>
                <input type="text" name="autor" id="autor" value="<?php if(isset($_POST["autor"])) echo $_POST["autor"];?>">
                <?php
                if(isset($_POST["autor"])&& $error_autor)
                    echo "<span class='error'> Campo Vacío</span>";
                 ?>
            </p>
            <p>
                <label for="descripcion">Descripción:</label>
                <textarea name="descripcion" id="descripcion"><?php if(isset($_POST["descripcion"])) echo $_POST["descripcion"];?></textarea>
                <?php
                if(isset($_POST["descripcion"])&& $error_descripcion)
                    echo "<span class='error'> Campo Vacío</span>";
                 ?>
            </p>
            <p>
                <label for="precio">Precio:</label>
                <input type="text" name="precio" id="precio" value="<?php if(isset($_POST["precio"])) echo $_POST["precio"];?>">
                <?php
                if(isset($_POST["precio"])&& $error_precio)
                {
                    if($_POST["precio"]=="")
                        echo "<span class='error'> Campo Vacío</span>";
                    else
                        echo "<span class='error'> El precio debe ser un número mayor que cero</span>";
              
                }
                ?>
            </p>
            <p>
                <label for="portada">Portada:</label>
                <input type="file" name="portada" id="portada" accept="image/*">
                <?php
                if(isset($_POST["btnAgregar"])&& $error_portada)
                {
                    if($_FILES["portada"]["error"])
                        echo "<span class='error'>Error en la subida del fichero</span>";
                    elseif(!explode(".",$_FILES["portada"]["name"]))
                        echo "<span class='error'>El archivo seleccionado no tiene extensión</span>";
                    elseif(!getimagesize($_FILES["portada"]["tmp_name"]))
                        echo "<span class='error'>El archivo seleccionado no es un archivo imagen</span>";
                    else
                        echo "<span class='error'>El archivo seleccionado supera los 750KB</span>";
                }

                ?>
            </p>
            <p>
                <button type="submit" name="btnAgregar">Agregar</button>
            </p>
        </form>
    </body>
    </html>