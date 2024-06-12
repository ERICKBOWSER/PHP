<?php


if(isset($_POST["btnContBorrarFoto"]))
{

    $datos_env_act["nombre_foto"]=FOTO_DEFECTO;
    $datos_env_act["id_usuario"]=$_POST["id_usuario"];
    $respuesta=consumir_servicios_REST(DIR_SERV."/actualizar_foto","PUT",$datos_env_act);
    $json=json_decode($respuesta,true);
    if(!$json)
    {
        session_destroy();
        die(error_page("Práctica Rec 3","<h1>Práctica Rec 3</h1><p>Sin respuesta oportuna de la API</p>"));  
    }

    if(isset($json["error_bd"]))
    {
        session_destroy();
        consumir_servicios_REST(DIR_SERV."/salir","POST",$datos_env);
        die(error_page("Práctica Rec 3","<h1>Práctica Rec 3</h1><p>".$json["error_bd"]."</p>"));
    }

    if(file_exists("images/".$_POST["foto_bd"]))
            unlink("images/".$_POST["foto_bd"]);

    $_POST["foto_bd"]=FOTO_DEFECTO;
    $_SESSION["borrada_foto"]=$_POST;
    $_SESSION["borrada_foto2"]=$_FILES["foto"];
    header("Location:index.php");
    exit;

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

        $respuesta=consumir_servicios_REST(DIR_SERV."/repetido_edit/usuarios/usuario/".$_POST["usuario"]."/id_usuario/".$id_usuario,"GET",$datos_env);
        $json=json_decode($respuesta,true);
        if(!$json)
        {
            session_destroy();
            die(error_page("Práctica Rec 3","<h1>Práctica Rec 3</h1><p>Sin respuesta oportuna de la API</p>"));  
        }

        if(isset($json["error_bd"]))
        {
            session_destroy();
            consumir_servicios_REST(DIR_SERV."/salir","POST",$datos_env);
            die(error_page("Práctica Rec 3","<h1>Práctica Rec 3</h1><p>".$json["error_bd"]."</p>"));
        }

        if(isset($json["no_auth"]))
        {
            session_unset();
            $_SESSION["seguridad"]="Usted ha dejado de tener acceso a la API. Por favor vuelva a loguearse.";
            header("Location:index.php");
            exit();
        }
        $error_usuario=$json["repetido"];

    }
 
    $error_dni=$_POST["dni"]=="" || !dni_bien_escrito($_POST["dni"]) || !dni_valido($_POST["dni"]);
    if(!$error_dni)
    {

        $respuesta=consumir_servicios_REST(DIR_SERV."/repetido_edit/usuarios/dni/".strtoupper($_POST["dni"])."/id_usuario/".$id_usuario,"GET",$datos_env);
        $json=json_decode($respuesta,true);
        if(!$json)
        {
            session_destroy();
            die(error_page("Práctica Rec 3","<h1>Práctica Rec 3</h1><p>Sin respuesta oportuna de la API</p>"));  
        }

        if(isset($json["error_bd"]))
        {
            session_destroy();
            consumir_servicios_REST(DIR_SERV."/salir","POST",$datos_env);
            die(error_page("Práctica Rec 3","<h1>Práctica Rec 3</h1><p>".$json["error_bd"]."</p>"));
        }

        if(isset($json["no_auth"]))
        {
            session_unset();
            $_SESSION["seguridad"]="Usted ha dejado de tener acceso a la API. Por favor vuelva a loguearse.";
            header("Location:index.php");
            exit();
        }
        $error_dni=$json["repetido"];

    }
    
    $error_foto=$_FILES["foto"]["name"]!="" && ($_FILES["foto"]["error"] || !explode(".", $_FILES["foto"]["name"])|| !getimagesize($_FILES["foto"]["tmp_name"] ) || $_FILES["foto"]["size"]>500*1024);//Foto no obligatoria
    //$error_foto=$_FILES["foto"]["name"]=="" || $_FILES["foto"]["error"] || !explode(".", $_FILES["foto"]["name"])|| !getimagesize($_FILES["foto"]["tmp_name"] ) || $_FILES["foto"]["size"]>500*1024;//Foto obligatoria
    $error_form=$error_nombre|| $error_usuario || $error_dni || $error_foto;
    
    if(!$error_form && isset($_POST["btnContEditar"]))
    {
        //No hay errores
        $datos_env["nombre"]=$nombre;
        $datos_env["usuario"]=$usuario;
        $datos_env["dni"]=strtoupper($dni);
        $datos_env["sexo"]=$sexo;
        $datos_env["subscripcion"]=$subscripcion;

        if($_POST["clave"]=="")
        {
            $respuesta=consumir_servicios_REST(DIR_SERV."/actualizar_usuario_sin_clave/".$id_usuario,"PUT",$datos_env);
        }
        else
        {
            $datos_env["clave"]=md5($_POST["clave"]);
            $respuesta=consumir_servicios_REST(DIR_SERV."/actualizar_usuario_con_clave/".$id_usuario,"PUT",$datos_env);
        }

        $json=json_decode($respuesta,true);
        if(!$json)
        {
            session_destroy();
            die(error_page("Práctica Rec 3","<h1>Práctica Rec 3</h1><p>Sin respuesta oportuna de la API</p>"));  
        }

        if(isset($json["error_bd"]))
        {
            session_destroy();
            consumir_servicios_REST(DIR_SERV."/salir","POST",$datos_env);
            die(error_page("Práctica Rec 3","<h1>Práctica Rec 3</h1><p>".$json["error_bd"]."</p>"));
        }

        if(isset($json["no_auth"]))
        {
            session_unset();
            $_SESSION["seguridad"]="Usted ha dejado de tener acceso a la API. Por favor vuelva a loguearse.";
            header("Location:index.php");
            exit();
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

                    $datos_env_act["nombre_foto"]=$nombre_nuevo;
                    $datos_env_act["id_usuario"]=$id_usuario;
                    $respuesta=consumir_servicios_REST(DIR_SERV."/actualizar_foto","PUT",$datos_env_act);
                    $json=json_decode($respuesta,true);
                    if(!$json)
                    {
                        session_destroy();
                        die(error_page("Práctica Rec 3","<h1>Práctica Rec 3</h1><p>Sin respuesta oportuna de la API</p>"));  
                    }
                
                    if(isset($json["error_bd"]))
                    {
                        if(file_exists("images/".$nombre_nuevo))
                            unlink("images/".$nombre_nuevo);
                        $mensaje="Usuario editado con éxito pero sin cambiar a la nueva imagen por un problema con la BD del servidor";
                    }

                    if($foto!=FOTO_DEFECTO && file_exists("images/".$foto))
                        unlink("images/".$foto);
                    
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
        $respuesta=consumir_servicios_REST(DIR_SERV."/repetido_insert/usuarios/usuario/".$_POST["usuario"],"GET");
        $json=json_decode($respuesta,true);
        if(!$json)
        {
            session_destroy();
            die(error_page("Práctica Rec 3","<h1>Práctica Rec 3</h1><p>Sin respuesta oportuna de la API</p>"));  
        }

        if(isset($json["error_bd"]))
        {
            session_destroy();
            consumir_servicios_REST(DIR_SERV."/salir","POST",$datos_env);
            die(error_page("Práctica Rec 3","<h1>Práctica Rec 3</h1><p>".$json["error_bd"]."</p>"));
        }
        $error_usuario=$json["repetido"];

    }
    $error_clave=$_POST["clave"]=="";
    $error_dni=$_POST["dni"]=="" || !dni_bien_escrito($_POST["dni"]) || !dni_valido($_POST["dni"]);
    if(!$error_dni)
    {

        $respuesta=consumir_servicios_REST(DIR_SERV."/repetido_insert/usuarios/dni/".strtoupper($_POST["dni"]),"GET");
        $json=json_decode($respuesta,true);
        if(!$json)
        {
            session_destroy();
            die(error_page("Práctica Rec 3","<h1>Práctica Rec 3</h1><p>Sin respuesta oportuna de la API</p>"));  
        }

        if(isset($json["error_bd"]))
        {
            session_destroy();
            consumir_servicios_REST(DIR_SERV."/salir","POST",$datos_env);
            die(error_page("Práctica Rec 3","<h1>Práctica Rec 3</h1><p>".$json["error_bd"]."</p>"));
        }
        $error_dni=$json["repetido"];

    }
 
    $error_foto=$_FILES["foto"]["name"]!="" && ($_FILES["foto"]["error"] || !explode(".", $_FILES["foto"]["name"])|| !getimagesize($_FILES["foto"]["tmp_name"] ) || $_FILES["foto"]["size"]>500*1024);//Foto no obligatoria
    //$error_foto=$_FILES["foto"]["name"]=="" || $_FILES["foto"]["error"] || !explode(".", $_FILES["foto"]["name"])|| !getimagesize($_FILES["foto"]["tmp_name"] ) || $_FILES["foto"]["size"]>500*1024;//Foto obligatoria
    $error_form=$error_nombre|| $error_usuario || $error_clave || $error_dni || $error_foto;
   
    if(!$error_form)
    {

        $datos_env_insert["usuario"]=$_POST["usuario"];
        $datos_env_insert["nombre"]=$_POST["nombre"];
        $datos_env_insert["clave"]=md5($_POST["clave"]);
        $datos_env_insert["dni"]=strtoupper($_POST["dni"]);
        $datos_env_insert["sexo"]=$_POST["sexo"];
        if(isset($_POST["subscripcion"]))
            $datos_env_insert["subscripcion"]=1;
        else
            $datos_env_insert["subscripcion"]=0;

        
        $respuesta=consumir_servicios_REST(DIR_SERV."/insertar_usuario","POST",$datos_env_insert);
        $json=json_decode($respuesta,true);
        if(!$json)
        {
            session_destroy();
            die(error_page("Práctica Rec 3","<h1>Práctica Rec 3</h1><p>Sin respuesta oportuna de la API</p>"));  
        }
    
        if(isset($json["error_bd"]))
        {
            session_destroy();
            consumir_servicios_REST(DIR_SERV."/salir","POST",$datos_env);
            die(error_page("Práctica Rec 3","<h1>Práctica Rec 3</h1><p>".$json["error_bd"]."</p>"));
        }

        $mensaje="Usuario insertado con éxito";

        if($_FILES["foto"]["name"]!="")
        {
            $ultm_id=$json["ultm_id"];
            $array_ext=explode(".", $_FILES["foto"]["name"]);
            $ext=".".end($array_ext);
            $nombre_nuevo="img_".$ultm_id.$ext;
            @$var=move_uploaded_file($_FILES["foto"]["tmp_name"],"images/".$nombre_nuevo);
            if($var)
            {
                $datos_env_act["nombre_foto"]=$nombre_nuevo;
                $datos_env_act["id_usuario"]=$ultm_id;
                $respuesta=consumir_servicios_REST(DIR_SERV."/actualizar_foto","PUT",$datos_env_act);
                $json=json_decode($respuesta,true);
                if(!$json)
                {
                    session_destroy();
                    die(error_page("Práctica Rec 3","<h1>Práctica Rec 3</h1><p>Sin respuesta oportuna de la API</p>"));  
                }
            
                if(isset($json["error_bd"]))
                {
                    if(file_exists("images/".$nombre_nuevo))
                        unlink("images/".$nombre_nuevo);
                    
                    $mensaje="Usuario insertado con éxito pero con la imagen por defecto por un problema en la BD del servidor";
                }
                
            }
            else
            {
                $mensaje="Usuario insertado con éxito pero con la imagen por defecto ya que no se ha podido mover la imagen a la carpeta destino en el servidor";
            }
          
        }

        $_SESSION["mensaje_accion"]=$mensaje;
        header("Location:index.php");
        exit();
    }
}


if(isset($_POST["btnContBorrar"]))
{

    $respuesta=consumir_servicios_REST(DIR_SERV."/borrar_usuario/".$_POST["btnContBorrar"],"DELETE",$datos_env);
    $json=json_decode($respuesta,true);
    if(!$json)
    {
        session_destroy();
        die(error_page("Práctica Rec 3","<h1>Práctica Rec 3</h1><p>Sin respuesta oportuna de la API</p>"));  
    }

    if(isset($json["error_bd"]))
    {

        session_destroy();
        consumir_servicios_REST(DIR_SERV."/salir","POST",$datos_env);
        die(error_page("Práctica Rec 3","<h1>Práctica Rec 3</h1><p>".$json["error_bd"]."</p>"));
    }

    if(isset($json["no_auth"]))
    {
        session_unset();
        $_SESSION["seguridad"]="Usted ha dejado de tener acceso a la API. Por favor vuelva a loguearse.";
        header("Location:index.php");
        exit();
    }

    if($_POST["foto"]!=FOTO_DEFECTO && file_exists("images/".$_POST["foto"]))
         unlink("images/".$_POST["foto"]);

    $_SESSION["mensaje_accion"]="Usuario borrado con éxito";
    $_SESSION["pag"]=1;//Al poner paginación cuándo borro siempre me voy página
    header("Location:index.php");
    exit;
    
}

if(isset($_POST["btnEditar"]) || isset($_POST["btnBorrarEditar"]))
{
    if(isset($_POST["btnEditar"]))
        $id_usuario=$_POST["btnEditar"];
    else
        $id_usuario=$_POST["id_usuario"];

    $respuesta=consumir_servicios_REST(DIR_SERV."/obtener_detalles/".$id_usuario,"GET",$datos_env);
    $json=json_decode($respuesta,true);
    if(!$json)
    {
        session_destroy();
        die(error_page("Práctica Rec 3","<h1>Práctica Rec 3</h1><p>Sin respuesta oportuna de la API</p>"));  
    }

    if(isset($json["error_bd"]))
    {

        session_destroy();
        consumir_servicios_REST(DIR_SERV."/salir","POST",$datos_env);
        die(error_page("Práctica Rec 3","<h1>Práctica Rec 3</h1><p>".$json["error_bd"]."</p>"));
    }

    if(isset($json["no_auth"]))
    {
        session_unset();
        $_SESSION["seguridad"]="Usted ha dejado de tener acceso a la API. Por favor vuelva a loguearse.";
        header("Location:index.php");
        exit();
    }

    $detalles_usu=$json["usuario"];
    if($detalles_usu)
    {
        $usuario=$detalles_usu["usuario"];
        $nombre=$detalles_usu["nombre"];
        $dni=$detalles_usu["dni"];
        $foto=$detalles_usu["foto"];
        $sexo=$detalles_usu["sexo"];
        $subscripcion=$detalles_usu["subscripcion"];
    }


    
}

if(isset($_POST["btnDetalles"]))
{
    $respuesta=consumir_servicios_REST(DIR_SERV."/obtener_detalles/".$_POST["btnDetalles"],"GET",$datos_env);
    $json=json_decode($respuesta,true);
    if(!$json)
    {
        session_destroy();
        die(error_page("Práctica Rec 3","<h1>Práctica Rec 3</h1><p>Sin respuesta oportuna de la API</p>"));  
    }

    if(isset($json["error_bd"]))
    {

        session_destroy();
        consumir_servicios_REST(DIR_SERV."/salir","POST",$datos_env);
        die(error_page("Práctica Rec 3","<h1>Práctica Rec 3</h1><p>".$json["error_bd"]."</p>"));
    }

    if(isset($json["no_auth"]))
    {
        session_unset();
        $_SESSION["seguridad"]="Usted ha dejado de tener acceso a la API. Por favor vuelva a loguearse.";
        header("Location:index.php");
        exit();
    }

    $detalles_usu=$json["usuario"];


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

   
        
    if($_SESSION["buscar"]=="")
    {
        $respuesta=consumir_servicios_REST(DIR_SERV."/obtener_usuarios","GET",$datos_env);
    }   
    else
    {
        
        $datos_env["buscar"]=$_SESSION["buscar"];
        $respuesta=consumir_servicios_REST(DIR_SERV."/obtener_usuarios_filtro","GET",$datos_env);
    
    }
    
    $json=json_decode($respuesta,true);
    if(!$json)
    {
        session_destroy();
        die(error_page("Práctica Rec 3","<h1>Práctica Rec 3</h1><p>Sin respuesta oportuna de la API</p>"));  
    }

    if(isset($json["error_bd"]))
    {
   
        session_destroy();
        consumir_servicios_REST(DIR_SERV."/salir","POST",$datos_env);
        die(error_page("Práctica Rec 3","<h1>Práctica Rec 3</h1><p>".$json["error_bd"]."</p>"));
    }
   
    if(isset($json["no_auth"]))
    {
       session_unset();
       $_SESSION["seguridad"]="Usted ha dejado de tener acceso a la API. Por favor vuelva a loguearse.";
       header("Location:index.php");
       exit();
    }

    $total_registros=count($json["usuarios"]);
    $n_pags=ceil($total_registros/$_SESSION["regs_mostrar"]);
}



//// Consulta para obtener los usuarios a listar en la Tabla


    
if($_SESSION["buscar"]=="")
{
    if($_SESSION["regs_mostrar"]==-1)
        $respuesta=consumir_servicios_REST(DIR_SERV."/obtener_usuarios","GET",$datos_env);
    else
        $respuesta=consumir_servicios_REST(DIR_SERV."/obtener_usuarios_pag/".$ini_pag."/".$_SESSION["regs_mostrar"],"GET",$datos_env);
}
else
{
    $datos_env["buscar"]=$_SESSION["buscar"];
    if($_SESSION["regs_mostrar"]==-1)
        $respuesta=consumir_servicios_REST(DIR_SERV."/obtener_usuarios_filtro","GET",$datos_env);
    else
        $respuesta=consumir_servicios_REST(DIR_SERV."/obtener_usuarios_filtro_pag/".$ini_pag."/".$_SESSION["regs_mostrar"],"GET",$datos_env);
}



$json=json_decode($respuesta,true);
if(!$json)
{
    session_destroy();
    die(error_page("Práctica Rec 3","<h1>Práctica Rec 3</h1><p>Sin respuesta oportuna de la API</p>"));  
}

if(isset($json["error_bd"]))
{

    session_destroy();
    consumir_servicios_REST(DIR_SERV."/salir","POST",$datos_env);
    die(error_page("Práctica Rec 3","<h1>Práctica Rec 3</h1><p>".$json["error_bd"]."</p>"));
}

if(isset($json["no_auth"]))
{
    session_unset();
    $_SESSION["seguridad"]="Usted ha dejado de tener acceso a la API. Por favor vuelva a loguearse.";
    header("Location:index.php");
    exit();
}


$usuarios=$json["usuarios"];

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Práctica Rec 3</title>
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
    <h1>Práctica Rec 3</h1>
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