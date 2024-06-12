<?php
require "config_bd.php";



function login($usuario,$clave)
{
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
        
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
        return $respuesta;
    }

    try{
        $consulta="select * from usuarios where usuario=? and clave=?";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute([$usuario,$clave]);

    }
    catch(PDOException $e){

        $respuesta["error"]="Imposible conectar:".$e->getMessage();
        $sentencia=null;
        $conexion=null;
        return $respuesta;
    }

    if($sentencia->rowCount()>0)
    {
        $respuesta["usuario"]=$sentencia->fetch(PDO::FETCH_ASSOC);
        session_name("ExamenRec_SW_23_24");
        session_start();
        $_SESSION["usuario"]=$respuesta["usuario"]["usuario"];
        $_SESSION["clave"]=$respuesta["usuario"]["clave"];
        $respuesta["api_session"]=session_id();
    }
    else
    {
        $respuesta["mensaje"]="Usuario no se encuentra registrado en la BD";
    }

    $sentencia=null;
    $conexion=null;
    return $respuesta;
}



function logueado($usuario,$clave)
{
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
        
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
        return $respuesta;
    }

    try{
        $consulta="select * from usuarios where usuario=? and clave=?";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute([$usuario,$clave]);

    }
    catch(PDOException $e){

        $respuesta["error"]="Imposible conectar:".$e->getMessage();
        $sentencia=null;
        $conexion=null;
        return $respuesta;
    }

    if($sentencia->rowCount()>0)
    {
        $respuesta["usuario"]=$sentencia->fetch(PDO::FETCH_ASSOC);
    }
    else
    {
        $respuesta["mensaje"]="Usuario no se encuentra registrado en la BD";
    }

    $sentencia=null;
    $conexion=null;
    return $respuesta;
}

function obtener_usuario($id_usuario){
    try{
        $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'")); 
    }
    catch(PDOException $e){
        $respuesta["error_bd"]="Imposible conectar a la BD. Error:".$e->getMessage();
        return $respuesta;
    }

    try{
       
        $consulta="select * from usuarios wherere id_usuario=?";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute([$id_usuario]);
        
    }
    catch(PDOException $e){
        $sentencia=null;
        $conexion=null;
        $respuesta["error_bd"]="Error en la consulta. Error:".$e->getMessage();
        return $respuesta;
    }

    $respuesta["usuarios"]=$sentencia->fetchAll(PDO::FETCH_ASSOC);
    
    $sentencia=null;
    $conexion=null;
    return $respuesta;
}


function  obtener_usuarios_guardia($dia,$hora){
    
    try{
        $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'")); 
    }
    catch(PDOException $e){
        $respuesta["error_bd"]="Imposible conectar a la BD. Error:".$e->getMessage();
        return $respuesta;
    }

    try{
        $consulta="SELECT horario_lectivo.*,usuarios.* FROM horario_lectivo  
        INNER JOIN usuarios ON horario_lectivo.usuario=usuarios.id_usuario 
        INNER JOIN grupos ON horario_lectivo.grupo=grupos.id_grupo 
        where dia=? and hora=? and grupos.nombre='GUARD'; ";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute([$dia,$hora]);


    }catch(PDOException $e){

        $sentencia=null;
        $conexion=null;
        $respuesta["error_bd"]="Error en la consulta. Error:".$e->getMessage();
        return $respuesta;
    }

    $respuesta["usuarios"]=$sentencia->fetchAll(PDO::FETCH_ASSOC);
    
    $sentencia=null;
    $conexion=null;
    return $respuesta;
}












?>
