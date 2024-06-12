<?php

require "src/conf_bd.php";


function login($datos)
{
    try{
        $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'")); 
    }
    catch(PDOException $e){
        $respuesta["error_bd"]="Imposible conectar a la BD. Error:".$e->getMessage();
        return $respuesta;
    }

    try{
       
        $consulta="select * from usuarios where lector=? AND clave=?";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute($datos);
        if($sentencia->rowCount()>0)
        {
            session_name("API_Pract3B_Rec_23_24");
            session_start();

            $respuesta["usuario"]=$sentencia->fetch(PDO::FETCH_ASSOC);
            $respuesta["api_key"]=session_id();


            $_SESSION["usuario"]=$respuesta["usuario"]["lector"];
            $_SESSION["clave"]=$respuesta["usuario"]["clave"];
            $_SESSION["tipo"]=$respuesta["usuario"]["tipo"];
            

        }
        else
            $respuesta["mensaje"]="El usuario no se encuentra registrado en la BD";


        $sentencia=null;
        $conexion=null;
        return $respuesta;
        
    }
    catch(PDOException $e){
        $sentencia=null;
        $conexion=null;
        $respuesta["error_bd"]="Error en la consulta. Error:".$e->getMessage();
        return $respuesta;
    }

}

function logueado($datos)
{
    try{
        $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'")); 
    }
    catch(PDOException $e){
        $respuesta["error_bd"]="Imposible conectar a la BD. Error:".$e->getMessage();
        return $respuesta;
    }

    try{
       
        $consulta="select * from usuarios where lector=? AND clave=?";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute($datos);
        
        if($sentencia->rowCount()>0)
            $respuesta["usuario"]=$sentencia->fetch(PDO::FETCH_ASSOC);
        else
            $respuesta["mensaje"]="El usuario no se encuentra registrado en la BD";


        $sentencia=null;
        $conexion=null;
        return $respuesta;
        
    }
    catch(PDOException $e){
        $sentencia=null;
        $conexion=null;
        $respuesta["error_bd"]="Error en la consulta. Error:".$e->getMessage();
        return $respuesta;
    }

}

    function obtener_libros_home(){
        try{
            $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'")); 
        }
        catch(PDOException $e){
            $respuesta["error_bd"]="Imposible conectar a la BD. Error:".$e->getMessage();
            return $respuesta;
        }
    
        try{
           
            $consulta="select * from libros ";
            $sentencia=$conexion->prepare($consulta);
            $sentencia->execute();
            $respuesta["libros"]=$sentencia->fetchAll(PDO::FETCH_ASSOC);
            $sentencia=null;
            $conexion=null;
            return $respuesta;
            
        }
        catch(PDOException $e){
            $sentencia=null;
            $conexion=null;
            $respuesta["error_bd"]="Error en la consulta. Error:".$e->getMessage();
            return $respuesta;
        }

    }


function insertar_libro($datos)
{
    try{
        $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'")); 
    }
    catch(PDOException $e){
        $respuesta["error_bd"]="Imposible conectar a la BD. Error:".$e->getMessage();
        return $respuesta;
    }

    try{
       
        $consulta="insert into libros(referencia,titulo,autor,descripcion,precio) values(?,?,?,?,?)";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute($datos);
         //$respuesta["ultm_referencia"]=$datos["referencia"];
       $respuesta["mensaje"]="Insercción  realizada con éxito";
        $sentencia=null;
        $conexion=null;
        return $respuesta;
        
    }
    catch(PDOException $e){
        $sentencia=null;
        $conexion=null;
        $respuesta["error_bd"]="Error en la consulta. Error:".$e->getMessage();
        return $respuesta;
    }

}


function actualizar_foto($datos)
{
    try{
        $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'")); 
    }
    catch(PDOException $e){
        $respuesta["error_bd"]="Imposible conectar a la BD. Error:".$e->getMessage();
        return $respuesta;
    }

    try{
       
        $consulta="update libros set portada=? where referencia=?";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute($datos);
        $respuesta["mensaje"]="Actualización realizada con éxito";
        $sentencia=null;
        $conexion=null;
        return $respuesta;
        
    }
    catch(PDOException $e){
        $sentencia=null;
        $conexion=null;
        $respuesta["error_bd"]="Error en la consulta. Error:".$e->getMessage();
        return $respuesta;
    }

}

function repetido_insertando($tabla,$columna,$valor)
{
    try{
        $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'")); 
    }
    catch(PDOException $e){
        $respuesta["error_bd"]="Imposible conectar a la BD. Error:".$e->getMessage();
        return $respuesta;
    }

    try{
       
        $consulta="select ".$columna." from ".$tabla." where ".$columna."=?" ;
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute([$valor]);
        $respuesta["repetido"]=$sentencia->rowCount()>0;
        $sentencia=null;
        $conexion=null;
        return $respuesta;
        
    }
    catch(PDOException $e){
        $sentencia=null;
        $conexion=null;
        $respuesta["error_bd"]="Error en la consulta. Error:".$e->getMessage();
        return $respuesta;
    }

}


function repetido_editando($tabla,$columna,$valor,$columna_clave,$valor_clave)
{
    try{
        $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'")); 
    }
    catch(PDOException $e){
        $respuesta["error_bd"]="Imposible conectar a la BD. Error:".$e->getMessage();
        return $respuesta;
    }

    try{
       
        $consulta="select ".$columna." from ".$tabla." where ".$columna."=? AND ".$columna_clave."<>?" ;
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute([$valor,$valor_clave]);
        $respuesta["repetido"]=$sentencia->rowCount()>0;
        $sentencia=null;
        $conexion=null;
        return $respuesta;
        
    }
    catch(PDOException $e){
        $sentencia=null;
        $conexion=null;
        $respuesta["error_bd"]="Error en la consulta. Error:".$e->getMessage();
        return $respuesta;
    }

}
//obtener los libros para la parte gest de  libros (La tabla con paginación)
function obtener_todos_libros()
{
    try{
        $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'")); 
    }
    catch(PDOException $e){
        $respuesta["error_bd"]="Imposible conectar a la BD. Error:".$e->getMessage();
        return $respuesta;
    }

    try{
       
        $consulta="select * from libros ";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute();
        $respuesta["libros"]=$sentencia->fetchAll(PDO::FETCH_ASSOC);
        $sentencia=null;
        $conexion=null;
        return $respuesta;
        
    }
    catch(PDOException $e){
        $sentencia=null;
        $conexion=null;
        $respuesta["error_bd"]="Error en la consulta. Error:".$e->getMessage();
        return $respuesta;
    }

}



function obtener_libros_pag($pagina,$registros)
{
    try{
        $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'")); 
    }
    catch(PDOException $e){
        $respuesta["error_bd"]="Imposible conectar a la BD. Error:".$e->getMessage();
        return $respuesta;
    }

    try{
       
        $consulta="select * from libros  LIMIT ".$pagina.",".$registros;
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute();
        $respuesta["libros"]=$sentencia->fetchAll(PDO::FETCH_ASSOC);
        $sentencia=null;
        $conexion=null;
        return $respuesta;
        
    }
    catch(PDOException $e){
        $sentencia=null;
        $conexion=null;
        $respuesta["error_bd"]="Error en la consulta. Error:".$e->getMessage();
        return $respuesta;
    }

}

function obtener_todos_libros_filtro($buscar)
{
    try{
        $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'")); 
    }
    catch(PDOException $e){
        $respuesta["error_bd"]="Imposible conectar a la BD. Error:".$e->getMessage();
        return $respuesta;
    }

    try{
       
        $consulta="select * from libros  and titulo LIKE '%".$buscar."%'";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute();
        $respuesta["libros"]=$sentencia->fetchAll(PDO::FETCH_ASSOC);
        $sentencia=null;
        $conexion=null;
        return $respuesta;
        
    }
    catch(PDOException $e){
        $sentencia=null;
        $conexion=null;
        $respuesta["error_bd"]="Error en la consulta. Error:".$e->getMessage();
        return $respuesta;
    }

}


function obtener_libros_filtro_pag($pagina,$registros,$buscar)
{
    try{
        $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'")); 
    }
    catch(PDOException $e){
        $respuesta["error_bd"]="Imposible conectar a la BD. Error:".$e->getMessage();
        return $respuesta;
    }

    try{
       
        $consulta="select * from libros and titulo LIKE '%".$buscar."%' LIMIT ".$pagina.",".$registros;
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute();
        $respuesta["libros"]=$sentencia->fetchAll(PDO::FETCH_ASSOC);
        $sentencia=null;
        $conexion=null;
        return $respuesta;
        
    }
    catch(PDOException $e){
        $sentencia=null;
        $conexion=null;
        $respuesta["error_bd"]="Error en la consulta. Error:".$e->getMessage();
        return $respuesta;
    }

}

function obtener_detalles_libro($referencia)
{
    try{
        $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'")); 
    }
    catch(PDOException $e){
        $respuesta["error_bd"]="Imposible conectar a la BD. Error:".$e->getMessage();
        return $respuesta;
    }

    try{
       
        $consulta="select * from libros where referencia=?";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute([$referencia]);
        $respuesta["libro"]=$sentencia->fetch(PDO::FETCH_ASSOC);//Devuelve false si no tiene
        $sentencia=null;
        $conexion=null;
        return $respuesta;
        
    }
    catch(PDOException $e){
        $sentencia=null;
        $conexion=null;
        $respuesta["error_bd"]="Error en la consulta. Error:".$e->getMessage();
        return $respuesta;
    }

}


function borrar_libro($referencia)
{
    try{
        $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'")); 
    }
    catch(PDOException $e){
        $respuesta["error_bd"]="Imposible conectar a la BD. Error:".$e->getMessage();
        return $respuesta;
    }

    try{
       
        $consulta="delete from libros where referencia=?";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute([$referencia]);
        $respuesta["mensaje"]="Usuario borrado con éxito";
        $sentencia=null;
        $conexion=null;
        return $respuesta;
        
    }
    catch(PDOException $e){
        $sentencia=null;
        $conexion=null;
        $respuesta["error_bd"]="Error en la consulta. Error:".$e->getMessage();
        return $respuesta;
    }

}



function actualizar_libro($datos)
{
    try{
        $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'")); 
    }
    catch(PDOException $e){
        $respuesta["error_bd"]="Imposible conectar a la BD. Error:".$e->getMessage();
        return $respuesta;
    }

    try{
       
        $consulta="update libros set titulo=?, autor=?, descripcion=?, precio=? where referencia=?";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute($datos);
        $respuesta["mensaje"]="Libro editado con éxito";
        $sentencia=null;
        $conexion=null;
        return $respuesta;
        
    }
    catch(PDOException $e){
        $sentencia=null;
        $conexion=null;
        $respuesta["error_bd"]="Error en la consultaAQUI. Error:".$e->getMessage();
        return $respuesta;
    }

}

?>