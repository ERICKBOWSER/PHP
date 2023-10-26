<?php
function mi_strlen($texto)
{
    $cont=0;
    while(isset($texto[$cont]))
        $cont++;

    return $cont;
}

function mi_explode($sep,$texto)
{
    $aux=[];
    $l_texto=mi_strlen($texto);
    $i=0;
    while($i<$l_texto && $texto[$i]==$sep)
        $i++;

    
    if($i<$l_texto)
    {
        $j=0;
        $aux[$j]=$texto[$i];
        for($i=$i+1;$i<$l_texto;$i++)
        {
            if($texto[$i]!=$sep)
            {
                $aux[$j].=$texto[$i];
            }
            else
            {

                while($i<$l_texto && $texto[$i]==$sep)
                    $i++;
                
                if($i<$l_texto)
                {
                    $j++;
                    $aux[$j]=$texto[$i];
                }
                
            }
        }


    }
    
    return $aux;
}

if(isset($_POST["btnSubir"]))
{
    $error_form=$_FILES["fichero"]["name"]=="" || $_FILES["fichero"]["error"] || $_FILES["fichero"]["type"]!="text/plain" || $_FILES["fichero"]["size"]>1000 * 1024;
   
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio4 Exam Anterior</title>
    <style>
        .error{color:red}
        .text_centrado{text-align:center}
        table,th,td{border:1px solid black}
        table{border-collapse:collapse;width:90%;margin:0 auto;text-align:center}
        th{background-color:#CCC}
    </style>
</head>
<body>
    <h1>Ejercicio 4</h1>
    <?php
    if(isset($_POST["btnSubir"]) && !$error_form)
    {
        // Si el fichero no se encuentra, lo movemos a la ruta
        @$var=move_uploaded_file($_FILES["fichero"]["tmp_name"],"Horario/horarios.txt");
        if(!$var)
            echo "<p>El fichero seleccionado no ha podido moverse a la carpeta destino</p>"; // Si no tiene permisos
    }

    @$fd=fopen("Horario/horarios.txt","r"); // Abrimos el fichero
    if($fd)
    {
        require "vistas/vista_horario.php";
    }
    else
    {
        require "vistas/vista_form_subida.php";
    }
    ?>
</body>
</html>