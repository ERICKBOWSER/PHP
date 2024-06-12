<?php


if(isset($_POST["btnContBorrarFoto"]))
{
    try{
    
        $consulta = "update usuarios set foto=? where id_usuario=?";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute([FOTO_DEFECTO,$_POST["id_usuario"]]);
        if(file_exists("images/".$_POST["foto_bd"]))
            unlink("images/".$_POST["foto_bd"]);

        $sentencia=null;
        $conexion=null;
        $_POST["foto_bd"]=FOTO_DEFECTO;
        $_SESSION["borrada_foto"]=$_POST;
        $_SESSION["borrada_foto2"]=$_FILES["foto"];
        header("Location:index.php");
        exit;
    }
    catch(PDOException $e){
        $sentencia=null;
        $conexion=null;
        session_destroy();
        die(error_page("Práctica Rec 2","<h1>Práctica Rec 2</h1><p>Imposible realizar la consulta. Error:".$e->getMessage()."</p>"));
    }
}

if(isset($_SESSION["borrada_foto"]))
{
    $_POST=$_SESSION["borrada_foto"];
    $_FILES["foto"]=$_SESSION["borrada_foto2"];
    unset($_SESSION["borrada_foto"]);
    unset($_SESSION["borrada_foto2"]);
}

if(isset($_POST["btnContEditar"]) || isset($_POST["btnBorrarFoto"]) || isset($_POST["btnNoBorrarFoto"]) || isset($_POST["btnContBorrarFoto"]))
{
    $id_usuario=$_POST["id_usuario"];
    $usuario=$_POST["usuario"];
    $nombre=$_POST["nombre"];
    $dni=$_POST["dni"];
    $foto=$_POST["foto_bd"];
    $sexo=$_POST["sexo"];
    if(isset($_POST["subscripcion"]))
        $subscripcion=1;
    else
        $subscripcion=0;

    //Una vez recogido valores compruebo errores
    $error_nombre=$_POST["nombre"]=="";
    $error_usuario=$_POST["usuario"]=="";
    if(!$error_usuario)
    {
        $error_usuario=repetido_editando($conexion,"usuarios","usuario",$_POST["usuario"],"id_usuario",$id_usuario);
        if(is_string($error_usuario))
        {
            $conexion=null;
            session_destroy();
            die(error_page("Práctica Rec 2","<h1>Práctica Rec 2</h1><p>".$error_usuario."</p>"));
        }
    }
 
    $error_dni=$_POST["dni"]=="" || !dni_bien_escrito($_POST["dni"]) || !dni_valido($_POST["dni"]);
    if(!$error_dni)
    {
        $error_dni=repetido_editando($conexion,"usuarios","dni",strtoupper($_POST["dni"]),"id_usuario",$id_usuario);
        if(is_string($error_dni))
        {
            $conexion=null;
            session_destroy();
            die(error_page("Práctica Rec 2","<h1>Práctica Rec 2</h1><p>".$error_dni."</p>"));
        }
    }
    
    $error_foto=$_FILES["foto"]["name"]!="" && ($_FILES["foto"]["error"] || !explode(".", $_FILES["foto"]["name"])|| !getimagesize($_FILES["foto"]["tmp_name"] ) || $_FILES["foto"]["size"]>500*1024);//Foto no obligatoria
    //$error_foto=$_FILES["foto"]["name"]=="" || $_FILES["foto"]["error"] || !explode(".", $_FILES["foto"]["name"])|| !getimagesize($_FILES["foto"]["tmp_name"] ) || $_FILES["foto"]["size"]>500*1024;//Foto obligatoria
    $error_form=$error_nombre|| $error_usuario || $error_dni || $error_foto;
    
    if(!$error_form && isset($_POST["btnContEditar"]))
    {
        //No hay errores

        try{
            
            if($_POST["clave"]=="")
            {
                $consulta = "update usuarios set nombre=?, usuario=?, dni=?, sexo=?, subscripcion=? where id_usuario=?";
                $datos_edit=[$nombre,$usuario,strtoupper($dni),$sexo,$subscripcion,$id_usuario];
            }
            else
            {
                $consulta = "update usuarios set nombre=?, usuario=?, clave=?, dni=?, sexo=?, subscripcion=? where id_usuario=?";
                $datos_edit=[$nombre,$usuario,md5($_POST["clave"]),strtoupper($dni),$sexo,$subscripcion,$id_usuario];
            }
            
            $sentencia=$conexion->prepare($consulta);
            $sentencia->execute($datos_edit);
            $sentencia=null;
          
        }
        catch(PDOException $e){
            $sentencia=null;
            $conexion=null;
            session_destroy();
            die(error_page("Práctica Rec 2","<h1>Práctica Rec 2</h1><p>Imposible realizar la consulta. Error:".$e->getMessage()."</p>"));
        }

        $mensaje="Usuario editado con éxito";
        if($_FILES["foto"]["name"]!="")
        {
            // generar nombre nueva foto
            $array_ext=explode(".",$_FILES["foto"]["name"]);
            $ext=".".end($array_ext);
            $nombre_nuevo="img_".$id_usuario.$ext;
            //mover nueva foto a images
            @$var=move_uploaded_file($_FILES["foto"]["tmp_name"],"images/".$nombre_nuevo);
            if($var)
            {
                //si nombre nueva foto es distinta a $foto(bd)
                if($foto!=$nombre_nuevo)
                {
                    try{
                      $consulta="update usuarios set foto=? where id_usuario=?";
                      $sentencia=$conexion->prepare($consulta);
                      $sentencia->execute([$nombre_nuevo,$id_usuario]);
                      $sentencia=null;
                      if($foto!=FOTO_DEFECTO && file_exists("images/".$foto))
                        unlink("images/".$foto);
                      
                    }
                    catch(PDOException $e){
                        $sentencia=null;
                        $conexion=null;
                        if(file_exists("images/".$nombre_nuevo))
                            unlink("images/".$nombre_nuevo);
                        $mensaje="Usuario editado con éxito pero sin cambiar a la nueva imagen por un problema con la BD del servidor";
                    }
                }
            }
            else
                $mensaje="Usuario editado con éxito pero sin cambiar a la nueva imagen, ya que ésta no se ha podido mover a la carpeta destino en el servidor";
          
        }
        $conexion=null;
        $_SESSION["mensaje_accion"]=$mensaje;
        header("Location:index.php");
        exit();

    }
    

}



if(isset($_POST["btnContNuevo"]))
{
    //compruebo los errores

    $error_nombre=$_POST["nombre"]=="";
    $error_usuario=$_POST["usuario"]=="";
    if(!$error_usuario)
    {
        $error_usuario=repetido($conexion,"usuarios","usuario",$_POST["usuario"]);
        if(is_string($error_usuario))
        {
            $conexion=null;
            session_destroy();
            die(error_page("Práctica Rec 2","<h1>Práctica Rec 2</h1><p>".$error_usuario."</p>"));
        }
    }
    $error_clave=$_POST["clave"]=="";
    $error_dni=$_POST["dni"]=="" || !dni_bien_escrito($_POST["dni"]) || !dni_valido($_POST["dni"]);
    if(!$error_dni)
    {
        $error_dni=repetido($conexion,"usuarios","dni",strtoupper($_POST["dni"]));
        if(is_string($error_dni))
        {
            $conexion=null;
            session_destroy();
            die(error_page("Práctica Rec 2","<h1>Práctica Rec 2</h1><p>".$error_dni."</p>"));
        }
    }
 
    $error_foto=$_FILES["foto"]["name"]!="" && ($_FILES["foto"]["error"] || !explode(".", $_FILES["foto"]["name"])|| !getimagesize($_FILES["foto"]["tmp_name"] ) || $_FILES["foto"]["size"]>500*1024);//Foto no obligatoria
    //$error_foto=$_FILES["foto"]["name"]=="" || $_FILES["foto"]["error"] || !explode(".", $_FILES["foto"]["name"])|| !getimagesize($_FILES["foto"]["tmp_name"] ) || $_FILES["foto"]["size"]>500*1024;//Foto obligatoria
    $error_form=$error_nombre|| $error_usuario || $error_clave || $error_dni || $error_foto;
   
    if(!$error_form)
    {

        try{
            if(isset($_POST["subscripcion"]))
                $subs=1;
            else
                $subs=0;

            $consulta = "insert into usuarios (usuario,nombre,clave,dni,sexo,subscripcion) values (?,?,?,?,?,?)";
            $sentencia=$conexion->prepare($consulta);
            $sentencia->execute([$_POST["usuario"],$_POST["nombre"],md5($_POST["clave"]),strtoupper($_POST["dni"]),$_POST["sexo"],$subs]);
            $sentencia=null;
          
        }
        catch(PDOException $e){
            $sentencia=null;
            $conexion=null;
            session_destroy();
            die(error_page("Práctica Rec 2","<h1>Práctica Rec 2</h1><p>Imposible realizar la consulta. Error:".$e->getMessage()."</p>"));
        }
       
        $mensaje="Uusario insertado con éxito";

        if($_FILES["foto"]["name"]!="")
        {
            $ultm_id=$conexion->lastInsertId();
            $array_ext=explode(".", $_FILES["foto"]["name"]);
            $ext=".".end($array_ext);
            $nombre_nuevo="img_".$ultm_id.$ext;
            @$var=move_uploaded_file($_FILES["foto"]["tmp_name"],"images/".$nombre_nuevo);
            if($var)
            {
                try{
                  
                    $consulta = "update usuarios set foto=? where id_usuario=?";
                    $sentencia=$conexion->prepare($consulta);
                    $sentencia->execute([$nombre_nuevo, $ultm_id]);
                    $sentencia=null;
                  
                }
                catch(PDOException $e){
                    if(file_exists("images/".$nombre_nuevo))
                        unlink("images/".$nombre_nuevo);
                    $sentencia=null;
                    $conexion=null;
                    $mensaje="Usuario insertado con éxito pero con la imagen por defecto por un problema en la BD del servidor";
                }
            }
            else
            {
                $mensaje="Usuario insertado con éxito pero con la imagen por defecto ya que no se ha podido mover la imagen a la carpeta destino en el servidor";
            }
          
        }

        $conexion=null;
        $_SESSION["mensaje_accion"]=$mensaje;
        header("Location:index.php");
        exit();
    }
}


if(isset($_POST["btnContBorrar"]))
{
    try{
    
        $consulta = "DELETE from usuarios where id_usuario=?";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute([$_POST["btnContBorrar"]]);
        if($_POST["foto"]!=FOTO_DEFECTO && file_exists("images/".$_POST["foto"]))
            unlink("images/".$_POST["foto"]);

        $sentencia=null;
        $conexion=null;
        $_SESSION["mensaje_accion"]="Usuario borrado con éxito";
        $_SESSION["pag"]=1;//Al poner paginación cuándo borro siempre me voy página
        header("Location:index.php");
        exit;
    }
    catch(PDOException $e){
        $sentencia=null;
        $conexion=null;
        session_destroy();
        die(error_page("Práctica Rec 2","<h1>Práctica Rec 2</h1><p>Imposible realizar la consulta. Error:".$e->getMessage()."</p>"));
    }
}

if(isset($_POST["btnEditar"]) || isset($_POST["btnBorrarEditar"]))
{
    if(isset($_POST["btnEditar"]))
        $id_usuario=$_POST["btnEditar"];
    else
        $id_usuario=$_POST["id_usuario"];

    try{
    
        $consulta = "select * from usuarios where id_usuario=?";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute([$id_usuario]);
        if($sentencia->rowCount()>0)
        {
            $detalles_usu=$sentencia->fetch(PDO::FETCH_ASSOC);
            $usuario=$detalles_usu["usuario"];
            $nombre=$detalles_usu["nombre"];
            $dni=$detalles_usu["dni"];
            $foto=$detalles_usu["foto"];
            $sexo=$detalles_usu["sexo"];
            $subscripcion=$detalles_usu["subscripcion"];

        }
       

        $sentencia=null;
    }
    catch(PDOException $e){
        $sentencia=null;
        $conexion=null;
        session_destroy();
        die(error_page("Práctica Rec 2","<h1>Práctica Rec 2</h1><p>Imposible realizar la consulta. Error:".$e->getMessage()."</p>"));
    }
}

if(isset($_POST["btnDetalles"]))
{
    try{
    
        $consulta = "select * from usuarios where id_usuario=?";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute([$_POST["btnDetalles"]]);
        if($sentencia->rowCount()>0)
            $detalles_usu=$sentencia->fetch(PDO::FETCH_ASSOC);
        else
            $detalles_usu=false;

        $sentencia=null;
    }
    catch(PDOException $e){
        $sentencia=null;
        $conexion=null;
        session_destroy();
        die(error_page("Práctica Rec 2","<h1>Práctica Rec 2</h1><p>Imposible realizar la consulta. Error:".$e->getMessage()."</p>"));
    }
}

///Código para paginación
if(isset($_POST["btnPag"]))
    $_SESSION["pag"]=$_POST["btnPag"];


if(!isset($_SESSION["pag"]))
    $_SESSION["pag"]=1;


if(isset($_POST["registros"]))
{
    $_SESSION["regs_mostrar"]=$_POST["registros"];
    $_SESSION["buscar"]=$_POST["buscar"];
    $_SESSION["pag"]=1;
} 
    

if(!isset($_SESSION["regs_mostrar"]))
    $_SESSION["regs_mostrar"]=3;



if(!isset($_SESSION["buscar"]))
    $_SESSION["buscar"]="";


if($_SESSION["regs_mostrar"]==-1)
{
    $n_pags=1;
}
else
{
    $ini_pag=($_SESSION["pag"]-1)*$_SESSION["regs_mostrar"];

    try{
        
        if($_SESSION["buscar"]=="")
        {
            $consulta = "SELECT * FROM usuarios WHERE tipo<>'admin'";
            
        }   
        else
        {
            $consulta = "SELECT * FROM usuarios WHERE tipo<>'admin' AND nombre LIKE '%".$_SESSION["buscar"]."%'";
     
        }
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute();

        
    }
    catch(PDOException $e){
        $sentencia=null;
        $conexion=null;
        session_destroy();
        die(error_page("Práctica Rec 2","<h1>Práctica Rec 2</h1><p>Imposible realizar la consulta. Error:".$e->getMessage()."</p>"));
    }

    $total_registros=$sentencia->rowCount();
    $sentencia=null;
    $n_pags=ceil($total_registros/$_SESSION["regs_mostrar"]);
}



//// Consulta para obtener los usuarios a listar en la Tabla

try{
    
    if($_SESSION["buscar"]=="")
    {
        if($_SESSION["regs_mostrar"]==-1)
            $consulta = "SELECT * FROM usuarios WHERE tipo<>'admin'";
        else
            $consulta = "SELECT * FROM usuarios WHERE tipo<>'admin' LIMIT ".$ini_pag.",".$_SESSION["regs_mostrar"];
    }
    else
    {
        if($_SESSION["regs_mostrar"]==-1)
            $consulta = "SELECT * FROM usuarios WHERE tipo<>'admin' AND nombre LIKE '%".$_SESSION["buscar"]."%'";
        else
            $consulta = "SELECT * FROM usuarios WHERE tipo<>'admin' AND nombre LIKE '%".$_SESSION["buscar"]."%' LIMIT ".$ini_pag.",".$_SESSION["regs_mostrar"];
    }
    $sentencia=$conexion->prepare($consulta);
    $sentencia->execute();
}
catch(PDOException $e){
    $sentencia=null;
    $conexion=null;
    session_destroy();
    die(error_page("Práctica Rec 2","<h1>Práctica Rec 2</h1><p>Imposible realizar la consulta. Error:".$e->getMessage()."</p>"));
}
$usuarios=$sentencia->fetchAll(PDO::FETCH_ASSOC);
$sentencia=null;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Práctica Rec 2</title>
    <style>
        .error{color:red}
        .en_linea{display:inline}
        .enlace{border:none;background:none;color:blue;text-decoration:underline;cursor:pointer}
        table{border-collapse:collapse;}
        table,th,td{border:1px solid black}
        th{background-color:#CCC}
        .reducida{height:100px}
        .img_editar{width:30%}
        .centrar{ width:80%;margin:0 auto;  } 
        .mensaje{font-size: 1.25rem;color:blue}
        #t_editar, #t_editar td{border:none}
        .centrado{text-align: center;}
        .d_flex{display:flex;justify-content: space-between;margin-bottom:0.5em}
    </style>
</head>
<body>
    <h1>Práctica Rec 2</h1>
    <div>
        Bienvenido <strong><?php echo $datos_usuario_log["usuario"];?></strong> - 
        <form class="en_linea" action="index.php" method="post">
            <button class="enlace" name="btnSalir" type="submit">Salir</button>
        </form>
    </div>

    <?php
    if(isset($_POST["btnBorrar"]))
    {
        require "vistas/vistas_admin/vista_conf_borrar.php";
    }

    if(isset($_POST["btnDetalles"]))
    {
        require "vistas/vistas_admin/vista_detalles.php";
    }

    if(isset($_POST["btnEditar"]) || isset($_POST["btnContEditar"]) || isset($_POST["btnBorrarEditar"]) || isset($_POST["btnBorrarFoto"]) || isset($_POST["btnNoBorrarFoto"]) || isset($_POST["btnContBorrarFoto"]))
    {
        require "vistas/vistas_admin/vista_editar.php";
    }


    if(isset($_POST["btnNuevo"]) || isset($_POST["btnBorrarNuevo"]) || isset($_POST["btnContNuevo"]))
    {
        require "vistas/vistas_admin/vista_usuario_nuevo.php";
    }

    if(isset($_SESSION["mensaje_accion"]))
    {
        echo "<p class='mensaje'>".$_SESSION["mensaje_accion"]."</p>";
        unset($_SESSION["mensaje_accion"]);
    }

    require "vistas/vistas_admin/vista_tabla_principal.php";
    ?>
</body>
</html>