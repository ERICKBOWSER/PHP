<?php
require "src/ctes_funciones.php";

if(isset($_POST["btnContBorrar"]))
{
    try{
        $conexion=mysqli_connect(SERVIDOR_BD,USUARIO_BD,CLAVE_BD,NOMBRE_BD);
        mysqli_set_charset($conexion,"utf8");
    }
    catch(Exception $e)
    {
        die(error_page("Práctica 8","<h1>Práctica 8</h1><p>No ha podido conectarse a la base de batos: ".$e->getMessage()."</p>"));
    }

    try{
        $consulta="delete from usuarios where id_usuario='".$_POST["btnContBorrar"]."'";
        mysqli_query($conexion, $consulta);

    }
    catch(Exception $e)
    {
        mysqli_close($conexion);
        die(error_page("Práctica 8","<h1>Práctica 8</h1><p>No ha podido realizarse la consulta: ".$e->getMessage()."</p>"));
    }

    if($_POST["nombre_foto"]!="no_imagen.jpg")
        unlink("Img/".$_POST["nombre_foto"]);

    mysqli_close($conexion);
    header("Location:index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Práctica 8</title>
    <style>
        table,td,th{border:1px solid black;}
        table{border-collapse:collapse;text-align:center;width:90%;margin:0 auto}
        th{background-color:#CCC}
        table img{width:50px;}
        .enlace{border:none;background:none;cursor:pointer;color:blue;text-decoration:underline}
        .error{color:red}
        .foto_detalle{width:20%}
    </style>
</head>
<body>
    <h1>Práctica 8</h1>
    <?php
    if(isset($_POST["btnDetalle"]))
    {
        require "vistas/vista_detalle.php"; 
    }

    if(isset($_POST["btnBorrar"]))
    {
        require "vistas/vista_conf_borrar.php";
    }

    if(isset($_POST["btnNuevoUsuario"]))
    {
        //Formulario para insertar nuevo usuario
        echo "<h2>Agregar Nuevo Usuario</h2>";
    }

    require "vistas/vista_tabla_principal.php";
    
    ?>
    
</body>
</html>