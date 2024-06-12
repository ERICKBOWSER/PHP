<?php

require "src/funciones.php";

if(isset($_POST["btnContNueva"]))
{
    
    $error_titulo=$_POST["titulo"]=="" || strlen($_POST["titulo"])>15;
    $error_director=$_POST["director"]=="" || strlen($_POST["director"])>15;
    if(!$error_titulo)
    {
        try{
            $conexion=mysqli_connect(SERVIDOR_BD,USUARIO_BD,CLAVE_BD,NOMBRE_BD);
            mysqli_set_charset($conexion,"utf8");
        }
        catch(Exception $e)
        {
            die(error_page("Práctica 9","<h1>Práctica 9</h1><p>No he podido conectarse a la base de batos: ".$e->getMessage()."</p>"));
        }

        $error_titulo=repetido($conexion,"peliculas","titulo",$_POST["titulo"]);
        
        if(is_string($error_titulo))
        {
            mysqli_close($conexion);
            die(error_page("Práctica 9","<h1>Práctica 9</h1><p>No se ha podido realizar la consulta: ".$error_titulo."</p>"));
        }
    }
    $error_sinopsis=$_POST["sinopsis"]=="";
    $error_tematica=$_POST["tematica"]=="";

    $error_caratula=$_FILES["caratula"]["name"]!="" && ($_FILES["caratula"]["error"] || !getimagesize($_FILES["caratula"]["tmp_name"]) || !tiene_extension($_FILES["caratula"]["name"]));

    $error_form=$error_titulo||$error_director|| $error_sinopsis || $error_tematica || $error_caratula;


    //Si no hay errores
    if(!$error_form)
    {
        //Inserto base de datos
        try{
            $consulta="insert into peliculas (titulo, director, sinopsis, tematica) values ('".$_POST["titulo"]."','".$_POST["director"]."','".md5($_POSt["sinopsis"])."','".$_POST["tematica"]."')";
            mysqli_query($conexion,$consulta);
        }
        catch(Exception $e)
        {
            mysqli_close($conexion);
            die(error_page("Práctica 9","<h1>Práctica 9</h1><p>No se ha podido realizar la consulta: ".$e->getMessage()."</p>"));
        }

        if($_FILES["caratula"]["name"]!="")
        {
            $last_id=mysqli_insert_id($conexion);
            $array_nombre=explode(".",$_FILES["caratula"]["name"]);
            $nombre_caratula="img_".$last_id.".".end($array_nombre);

            @$var=move_uploaded_file($_FILES["caratula"]["tmp_name"],"Img/".$nombre_caratula);
            if($var)
            {
                try{
                    $consulta="update peliculas set caratula='".$nombre_caratula."' where id_Pelicula='".$last_id."'";
                    mysqli_query($conexion,$consulta);
                }
                catch(Exception $e)
                {
                    unlink("Img/".$nombre_caratula);//Al no poder actualizar borro la nueva que acabo de mover
                    mysqli_close($conexion);
                    die(error_page("Práctica 9","<h1>Práctica 9</h1><p>No se ha podido realizar la consulta: ".$e->getMessage()."</p>"));
                }
            }    

        }

        mysqli_close($conexion);
        header("Location:index.php");
        exit;
    }
}
if(isset($_POST["btnContBorrar"]))
{
    try{
        $conexion=mysqli_connect(SERVIDOR_BD,USUARIO_BD,CLAVE_BD,NOMBRE_BD);
        mysqli_set_charset($conexion,"utf8");
    }
    catch(Exception $e)
    {
        die(error_page("Práctica 9","<h1>Práctica 9</h1><p>No ha podido conectarse a la base de batos: ".$e->getMessage()."</p>"));
    }

    try{
        $consulta="delete from peliculas where idPelicula='".$_POST["btnContBorrar"]."'";
        mysqli_query($conexion, $consulta);

    }
    catch(Exception $e)
    {
        mysqli_close($conexion);
        die(error_page("Práctica 9","<h1>Práctica 9</h1><p>No ha podido realizarse la consulta: ".$e->getMessage()."</p>"));
    }

    if($_POST["nombre_caratula"]!="no_imagen.jpg")
        unlink("Img/".$_POST["nombre_caratula"]);

    mysqli_close($conexion);
    header("Location:index.php");
    exit();
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        table,
        td,
        th {
            border: 1px solid black;
        }

        table {
            border-collapse: collapse;
            text-align: center;
            width: 60%;
        }

        th {
            background-color: #CCC
        }

        table img {
            width: 50px;
        }

        .enlace {
            border: none;
            background: none;
            cursor: pointer;
            color: blue;
            text-decoration: underline
        }

        .error {
            color: red
        }

        .caratula_detalle {
            height: 250px
        }

        .paralelo {
            display: flex
        }

        .centrado {
            text-align: center
        }
    </style>
</head>

<body>
    <h1>Videoclub</h1>
    <h2>Peliculas</h2>

    <?php

    require "vistas/vista_tabla_principal.php";

    if (isset($_POST["btnEditar"]) || isset($_POST["btnContEditar"]) || isset($_POST["btnBorrarFoto"]) || isset($_POST["btnNoBorrarFoto"]) || isset($_POST["btnContBorrarFoto"])) {
        require "vistas/vista_editar.php";
    }

    if (isset($_POST["btnDetalle"])) {
        require "vistas/vista_detalle.php";
    }

    if (isset($_POST["btnBorrar"])) {
        require "vistas/vista_conf_borrar.php";
    }

    if (isset($_POST["btnNuevaPelicula"]) || isset($_POST["btnContNueva"])) {
        require "vistas/vista_nueva_pelicula.php";
    }




    ?>

</body>

</html>