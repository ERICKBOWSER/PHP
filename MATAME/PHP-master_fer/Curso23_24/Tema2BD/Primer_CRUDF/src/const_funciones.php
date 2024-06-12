<?php

function error_page($title,$body){ //PARA CUANDO DE DERROR EL TRY CATCH DE ABAJO
    //CON EL DIE TERMINARIA LA PAGINA ASI QUE LE METO QUE TERMINE CON LA ESTRUCTURA DE UNA PAGINA

    $page = '<!DOCTYPE html> 
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>'.$title.'</title>
    </head>
    <body>'.$body.'
        
    </body>
    </html>';
    return $page; //DEVUELVE LA PAGINA COMO UN STRING ENTERO
}
function repetido($conexion,$tabla,$columna,$valor){

    try {
    
        $consulta="select * from ".$tabla." where ".$columna."='".$valor."'";
        $resultado=mysqli_query($conexion,$consulta);
        $respuesta=mysqli_num_rows($resultado)>0;
        mysqli_free_result($resultado);
        
    } catch (Exception $e) {

        mysqli_close($conexion);
        $respuesta=(error_page("Practica 1º CRUD","<h1>Practica 1º CRUD</h1><p>No ha podido hacer la consulta: ".$e->getMessage()."</p></body></html>"));
        
    }
    return $respuesta;

}

function repetido_editando($conexion,$tabla,$columna,$valor,$columna_clave,$valor_clave){

    try {
    
        $consulta="select * from ".$tabla." where ".$columna."='".$valor."'";
        $resultado=mysqli_query($conexion,$consulta);
        $respuesta=mysqli_num_rows($resultado)>0;
        mysqli_free_result($resultado);
        
    } catch (Exception $e) {

        mysqli_close($conexion);
        $respuesta=(error_page("Practica 1º CRUD","<h1>Practica 1º CRUD</h1><p>No ha podido hacer la consulta: ".$e->getMessage()."</p></body></html>"));
        
    }
    return $respuesta;

}
?>