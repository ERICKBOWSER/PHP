<?php
session_name("primer_CRUD");
session_start();

require "src/ctes_funciones.php";

if(isset($_POST["btnContEditar"]))
{
    //Errores cuándo edito
    $error_nombre=$_POST["nombre"]=="" || strlen($_POST["nombre"])>30;
    $error_usuario=$_POST["usuario"]==""|| strlen($_POST["usuario"])>20;
    if(!$error_usuario)
    {
        try
        {
            $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        }
        catch(PDOException $e)
        {
            session_destroy();
            die(error_page("Práctica 1º CRUD","<h1>Práctica 1º CRUD</h1><p>No he podido conectarse a la base de batos: ".$e->getMessage()."</p>"));
        }
           
        $error_usuario=repetido($conexion,"usuarios","usuario",$_POST["usuario"],"id_usuario",$_POST["btnContEditar"]);
            
        if(is_string($error_usuario))
        {
            $conexion=null;
            session_destroy();
            die(error_page("Práctica 1º CRUD","<h1>Práctica 1º CRUD</h1><p>No se ha podido realizar la consulta: ".$error_usuario."</p>"));
        }
            
    }
    $error_clave=strlen($_POST["clave"])>15;
    $error_email=$_POST["email"]=="" || strlen($_POST["email"])>50 || !filter_var($_POST["email"],FILTER_VALIDATE_EMAIL);
    if(!$error_email)
    {
        if(!isset($conexion))
        {
            try
            {
                $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
            }
            catch(PDOException $e)
            {
                session_destroy();
                die(error_page("Práctica 1º CRUD","<h1>Práctica 1º CRUD</h1><p>No he podido conectarse a la base de batos: ".$e->getMessage()."</p>"));
            }
        }
        $error_email=repetido($conexion,"usuarios","email",$_POST["email"],"id_usuario",$_POST["btnContEditar"]);
        
        if(is_string($error_email))
        {
            $conexion=null;
            session_destroy();
            die(error_page("Práctica 1º CRUD","<h1>Práctica 1º CRUD</h1><p>No se ha podido realizar la consulta: ".$error_email."</p>"));
        }
            
    }

    $error_form=$error_nombre||$error_usuario||$error_clave||$error_email;

    if(!$error_form)
    {
       

        try{
            if($_POST["clave"]=="")
            {
                $consulta="update usuarios set nombre=?, usuario=?, email=? where id_usuario=?";
                $datos=[$_POST["nombre"],$_POST["usuario"],$_POST["email"],$_POST["btnContEditar"]];
            }
            else
            {
                $consulta="update usuarios set nombre=?, usuario=?, clave=?, email=? where id_usuario=?";
                $datos=[$_POST["nombre"],$_POST["usuario"],md5($_POST["clave"]),$_POST["email"],$_POST["btnContEditar"]];
            }
            
            $sentencia=$conexion->prepare($consulta);
            $sentencia->execute($datos);
        }
        catch(PDOException $e)
        {
            $sentencia=null;
            $conexion=null;
            session_destroy();
            die(error_page("Práctica 1º CRUD","<h1>Práctica 1º CRUD</h1><p>No se ha podido hacer la consulta: ".$e->getMessage()."</p>"));
        }

        $sentencia=null;
        $conexion=null;


        $_SESSION["mensaje"]="El usuario ha sido actualizado con éxito";
        header("Location:index.php");
        exit;
        
    }

}

if(isset($_POST["btnContBorrar"]))
{
    try
    {
        $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    }
    catch(PDOException $e)
    {
        session_destroy();
        die(error_page("Práctica 1º CRUD","<h1>Práctica 1º CRUD</h1><p>No he podido conectarse a la base de batos: ".$e->getMessage()."</p>"));
    }

    try{
        
        $consulta="delete from usuarios where id_usuario=?";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute([$_POST["btnContBorrar"]]);
    }
    catch(PDOException $e)
    {
        $sentencia=null;
        $conexion=null;
        session_destroy();
        die(error_page("Práctica 1º CRUD","<h1>Práctica 1º CRUD</h1><p>No se ha podido hacer la consulta: ".$e->getMessage()."</p>"));
    }

    $sentencia=null;
    $conexion=null;

    $_SESSION["pag"]=1;
    $_SESSION["mensaje"]="El usuario ha sido borrado con éxito";
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
        table{border-collapse:collapse;text-align:center;width:80%;margin:0 auto}
        th{background-color:#CCC}
        table img{width:50px;}
        .enlace{border:none;background:none;cursor:pointer;color:blue;text-decoration:underline}
        .error{color:red}
        .mensaje{color:blue;font-size:1.5em}  
        #paginas{width:80%;margin:0 auto;text-align:center;}
        #paginas button{margin:0 0.25em;padding:0.5em}
        #regis_busc{width:80%;margin:0 auto;display:flex;justify-content:space-between}
    </style>
</head>
<body>
    <h1>Práctica 1º CRUD</h1>
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
    
   $conexion=null;

    ?>
</body>
</html>