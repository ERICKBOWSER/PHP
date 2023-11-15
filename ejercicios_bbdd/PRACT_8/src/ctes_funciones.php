<?php
    DEFINE("SERVIDOR_BD", "localhost");
    DEFINE("USUARIO_BD", "jose");
    DEFINE("CLAVE_BD", "josefa");
    DEFINE("NOMBRE_BD", "bd_cv");


    function errorPage($title, $body){
        $page = '<!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8>
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>' . $title . '</title>
        </head>
        <body>' . $body . '</body>
        </html>';

        return $page;
    }

    function repetido($conexion, $tabla, $columna, $valor, $columnaClave=null, $valorClave=null){
        try{
            if(isset($columnaClave)){
                $consulta = "SELECT * FROM " . $tabla . " WHERE " . $columna . "='" . $valor . "' AND " . $columnaClave . "<>'" . $valorClave . "'";
            }else{
                $consulta = "SELECT * FROM " . $tabla . " WHERE " . $columna . "='" . $valor . "'";
            }

            $resultado = mysqli_query($conexion, $consulta);
            $respuesta = mysqli_num_rows($resultado) > 0;
            mysqli_free_result($resultado);

        }catch(Exception $e){
            $respuesta = $e->getMessage();
        }
        return $respuesta;
    }



?>