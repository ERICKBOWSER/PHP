
<?php

  if(isset($_POST["btEnviar"])){                                                       //ESTO SE HACE PARA VER SI UN ARCHIVO ES IMAGEN O NO      //ESTO PARA DECIR QUE LA IMAGEN SEA MYOR DE 500KB

    $error_archivo=$_FILES["archivo"]["name"]=="" && $_FILES["archivo"]["error"] || $_FILES["archivo"]["type"]!="text/plain"|| $_FILES["archivo"]["size"] > 1000*1024; 

}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>.error{color:red;}</style>
</head>
<body>

    <form method="post" action="Examen2.php" enctype="multipart/form-data">
        <p>
            <label>Sube el fichero: max(1MB)</label>
            <input type="file" name="archivo" id="archivo" accept="text/plain">
        </p>

        <p>
        <button type="submit" name="btEnviar">Enviar</button>
        </p>
    </form>
    <?php

        if(isset($_POST["btEnviar"]) && $error_archivo) {

            if($_FILES["archivo"]["name"]!=""){ //Si he seleccionado algo

                if($_FILES["archivo"]["error"]){ //Si da error

                    echo "<span class='error'>No se ha podido subir el archivo</<span>";

                }elseif(!getimagesize($_FILES["archivo"]["tmp_name"])){ //SI no selecciona un txt

                    echo "<span class='error'>No has seleccionado un archivo de tipo texto</<span>";

                }else{ //SI supera el peso

                    echo "<span class='error'>El archivo seleccionado supera los 500KB</<span>";
                }
            }

        }elseif(isset($_POST["btEnviar"]) && !$error_archivo) {


            @$var=move_uploaded_file($_FILES["archivo"]["tmp_name"],"Ficheros/archivo.txt"); //PARA MOVER LA IMAGEN SUBIDA A OTRO SITIO
            if($var){ //LO DEL @$var y esto es porque si no pega un error raro

                echo "<p>Archivo movido con exito</p>";
            }else{
                echo "<p>No se ha podido mover el archivo a la carpeta destino en el servidor</p>";
            }
  
        }  

    ?>

</body>
</html>