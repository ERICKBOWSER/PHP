<?php

    if(isset($_POST["btEnviar"])){                                                       //ESTO SE HACE PARA VER SI UN ARCHIVO ES IMAGEN O NO      //ESTO PARA DECIR QUE LA IMAGEN SEA MYOR DE 500KB

        $error_archivo=$_FILES["archivo"]["name"]=="" && $_FILES["archivo"]["error"] || !getimagesize($_FILES["archivo"]["tmp_name"]) || $_FILES["archivo"]["size"] > 500*1024; 
        //para que da igual si se pone o no  $error_archivo=$_FILES["archivo"]["name"]=="";

        //archivo puede dar varias variables
        //name
        //error
        //size
        //type
        //tmp_name
    }

    if(isset($_POST["btEnviar"]) && !$error_archivo){

        //echo "Contesto con la info del archivo subido";
    ?>
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Document</title>
                <style>.tam_imag{width:35%}</style>
            </head>
            <body>
                <h1>Teoria subir ficheros al servdior</h1>
                <h2>Datos del archivo subido</h2>
                <?php

                    $nombre_nuevo=md5(uniqid(uniqid(),true));//GENERA UN NUMERO UNICO
                    $array_nombre=explode(".",$_FILES["archivo"]["name"]);
                    $extension="";//PARA EXTENSION VACIA
                    if(count($array_nombre)>1){ //SI NO LLEVA EXTENSION

                        $extension=".".end($array_nombre);
                        
                    }
                    $nombre_nuevo.=".".$extension; //CONCATENACION DE NOMBRE NUEVO Y EXTENSION .= ES PARA CONCATENAR 2 STRINGS
                    @$var=move_uploaded_file($_FILES["archivo"]["tmp_name"],"images/".$nombre_nuevo); //PARA MOVER LA IMAGEN SUBIDA A OTRO SITIO
                    if($var){ //LO DEL @$var y esto es porque si no pega un error raro

                        echo "<h3>Foto</h3>";
                        echo "<p><strong>Nombre: </strong>".$_FILES["archivo"]["name"]."</p>";
                        echo "<p><strong>Tipo: </strong>".$_FILES["archivo"]["type"]."</p>";
                        echo "<p><strong>Tamaño: </strong>".$_FILES["archivo"]["size"]."</p>";
                        echo "<p><strong>Error: </strong>".$_FILES["archivo"]["error"]."</p>";
                        echo "<p><strong>Archivo en el temporal del servidor: </strong>".$_FILES["archivo"]["tmp_name"]."</p>";
                        echo "<p>La imagen se ha subido con exito</p>";
                        echo "<p><img class='tam_imag' src='images/".$nombre_nuevo."' alt='Foto' title='Foto' /></p>";

                    }else{
                        echo "<p>No se ha podido mover la imagen a la carpeta destino en el servidor</p>";
                    }
                    
                ?>
                
            </body>
            </html>

        <?php
    } else{


?>

        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Subir archivos al servidor</title>
            <style>
                .error{color:red};
            </style>
        </head>
        <body>
            
            <h1>Teoria subir ficheros al servidor</h1>
            <form action="Archivos.php" method="post" enctype="multipart/form-data">
                <p>
                    <label for="archivo">Selecciona un archivo imagen (Max 500KB):</label>
                    <input type="file" name="archivo" id="archivo" accept="image/*">
                    <?php

                        if(isset($_POST["btEnviar"]) && $error_archivo) {

                            if($_FILES["archivo"]["name"]!=""){ //Si he seleccionado algo

                                if($_FILES["archivo"]["error"]){ //Si da error
 
                                    echo "<span class='error'>No se ha podido subir el archivo</<span>";
    
                                }elseif(!getimagesize($_FILES["archivo"]["tmp_name"])){ //SI no selecciona una imagen
    
                                    echo "<span class='error'>No has seleccionado un archivo de tipo imagen</<span>";
    
                                }else{ //SI supera el peso
    
                                    echo "<span class='error'>El archivo seleccionado supera los 500KB</<span>";
                                }
                            }

                           

                        }


                    ?>
                </p>


                <p>
                    <button type="submit" name="btEnviar">Enviar</button>
                </p>
            </form>
        </body>
        </html>
    <?php
    }
    ?>