<?php
    if(isset($_POST["btnEnviar"])){
        // Para archivos (Crea un arrar bidimensional que tiene parametros como size, temporal_name, error, type)
        $errorArchivo = $_FILES["archivo"]["name"] == ""
            || $_FILES["archivo"]["error"]
            || !getimagesize($_FILES["archivo"]["tmp_name"]) /*Comprobamos si es una imagen*/
            || $_FILES["archivo"]["size"] > 200 * 1024; 

            // getimagesize() si le pasas un archivo que no es una imagen devuelve false
    }
    
    if(isset($_POST["btnEnviar"]) && !$errorArchivo){
        echo "Contesto con la info del archivo subido";

    }else{


?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Teoría subir ficheros al servidor</title>
        <style>
            .color{red};
        </style>
    </head>
    <body>
        <h1>Teoría subir ficheros al servidor</h1>
        <form action ="index.php" method = "POST" enctype="multipart/form-data">
            <p>
                <label for="archivo">Seleccione un archivo imagen(Máx 500KB): </label>
                <input type="file" name="archivo" id="archivo" accept="image/*"/> <!-- accept es para especificar el tipo de ficheros que va a admitir -->       
                <?php
                    if(isset($_POST["btnEnviar"]) && $errorArchivo){

                        if($_FILES["archivo"]["name"] != ""){

                            if($_FILES["archivo"]["error"]){
                                echo "<span class='error'>No se ha podido subir el archivo al servidor</span>";
    
                           }elseif(!getimagesize($_FILES["archivo"]["tmp_name"])){
                                echo "<span class='error'>No has seleccionado un archivo de tipo imagen</span>";
    
                           }else{
                                echo "<span class='error'>El archivo seleccionado supera los 200KB</span>";
    
                           }
                        }

                    }
                ?>
            </p>
            <p>
                <button type="submit" name="btnEviar">Enviar</button>

            </p>
        </form>
    </body>
    </html>

<?php
}
?>