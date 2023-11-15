<?php
require "src/ctes_funciones.php";

if(isset($_POST["btnContEditar"]))
{
    //Errores cuándo edito
    $error_nombre=$_POST["nombre"]=="" || strlen($_POST["nombre"])>30;
    $error_usuario=$_POST["usuario"]==""|| strlen($_POST["usuario"])>20;
    if(!$error_usuario)
    {
        try{
            $conexion=mysqli_connect(SERVIDOR_BD,USUARIO_BD,CLAVE_BD,NOMBRE_BD);
            mysqli_set_charset($conexion,"utf8");
        }
        catch(Exception $e)
        {
            die(error_page("Práctica 1º CRUD","<h1>Práctica 1º CRUD</h1><p>No he podido conectarse a la base de batos: ".$e->getMessage()."</p>"));
        }
        $error_usuario=repetido_editando($conexion,"usuarios","usuario",$_POST["usuario"],"id_usuario",$_POST["btnContEditar"]);
            
         if(is_string($error_usuario))
            die($error_usuario);
    }
    $error_clave=strlen($_POST["clave"])>15;
    $error_email=$_POST["email"]=="" || strlen($_POST["email"])>50 || !filter_var($_POST["email"],FILTER_VALIDATE_EMAIL);
    if(!$error_email)
    {
        if(!isset($conexion))
        {
            try{
                $conexion=mysqli_connect(SERVIDOR_BD,USUARIO_BD,CLAVE_BD,NOMBRE_BD);
                mysqli_set_charset($conexion,"utf8");
            }
            catch(Exception $e)
            {
                die(error_page("Práctica 1º CRUD","<h1>Práctica 1º CRUD</h1><p>No he podido conectarse a la base de batos: ".$e->getMessage()."</p>"));
            }
        }
        $error_email=repetido_editando($conexion,"usuarios","email",$_POST["email"],"id_usuario",$_POST["btnContEditar"]);
        
        if(is_string($error_email))
            die($error_email);
    }

    $error_form=$error_nombre||$error_usuario||$error_clave||$error_email;

    if(!$error_form)
    {
        try{

            if($_POST["clave"]=="")
                $consulta="update usuarios set nombre='".$_POST["nombre"]."', usuario='".$_POST["usuario"]."', email='".$_POST["email"]."' where id_usuario='".$_POST["btnContEditar"]."'";
            else
                $consulta="update usuarios set nombre='".$_POST["nombre"]."', usuario='".$_POST["usuario"]."', clave='".md5($_POST["clave"])."', email='".$_POST["email"]."' where id_usuario='".$_POST["btnContEditar"]."'";
            
            mysqli_query($conexion,$consulta);
        }
        catch(Exception $e)
        {
            mysqli_close($conexion);
            die(error_page("Práctica 1º CRUD","<h1>Práctica 1º CRUD</h1><p>No se ha podido hacer la consulta: ".$e->getMessage()."</p>"));
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
        die(error_page("Práctica 1º CRUD","<h1>Listado de los usuarios</h1><p>No ha podido conectarse a la base de batos: ".$e->getMessage()."</p>"));
    }

    try{
        $consulta="delete from usuarios where id_usuario='".$_POST["btnContBorrar"]."'";
        mysqli_query($conexion, $consulta);
    }
    catch(Exception $e)
    {
        mysqli_close($conexion);
        die(error_page("Práctica 1º CRUD","<h1>Listado de los usuarios</h1><p>No ha podido conectarse a la base de batos: ".$e->getMessage()."</p>"));
    }

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
    <title>Práctica 1º CRUD</title>
    <style>
        table,td,th{border:1px solid black}
        table{border-collapse:collapse;text-align:center}
        th{background-color:#CCC}
        table img{width:50px;}
        .enlace{border:none;background:none;cursor:pointer;color:blue;text-decoration:underline}
        .error{color:red}  
    </style>
</head>
<body>
    <h1>Listado de los usuarios</h1>
    <?php
    require "vistas/vista_tabla.php";

    if(isset($_POST["btnDetalle"]))
    {
        require "vistas/vista_detalle.php";
    }
    elseif(isset($_POST["btnBorrar"]))
    {
       require "vistas/vista_conf_borrar.php";
    }
    elseif(isset($_POST["btnEditar"]) || isset($_POST["btnContEditar"]) )
    {
       require "vistas/vista_editar.php";
    }
    else
    {
        require "vistas/vista_nuevo.php";
    }
    
    mysqli_close($conexion);

    ?>
</body>
</html>