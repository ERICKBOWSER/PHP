<?php
    function errorPage($title, $body){
        // SE HACE CON COMILLAS SIMPLES PORQUE HAY COMILLAS DOBLES DENTRO DEL HTML
        $page = '<!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>' . $title . '</title>
        </head>
        <body>' . $body . '</body>
        </html>';
        return $page;
    }

    function repetido($conexion, $tabla, $columna, $valor){

        try{
            $consulta = "SELECT * FROM " . $tabla . " WHERE " . $columa . "='" . $valor . "'"; //PUEDE IR FUERA

            $resultado = mysqli_query($conexion, $consulta);
            $respuesta = mysqli_num_rows($resultado) > 0;
            mysqli_free_result($conexion);


        } catch(Exception $e){
        
            mysqli_close($conexion); // SI FALLA LA CONSULTA HAY QUE CERRAR LA CONEXIÓN OBLIGATORIAMENTE

            die(errorPage("Práctica 1º CRUD", "<h1>Práctica 1º CRUD</h1><p>No se ha podido realizar la consulta: " . $e->getMessage() . "</p></body></html>"));
        } 

        return $respuesta;
    }





?>