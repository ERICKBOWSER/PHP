<?php
require "config_bd.php";

function login($usuario, $clave){
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
       
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
        return $respuesta;
    }

    try{
        $consulta="SELECT * FROM usuarios WHERE lector=? AND clave=?";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute([$usuario, $clave]);
    }catch(PDOException $e){
        $respuesta["error"]="Imposible realizar la consulta desde login";
        $sentencia=null;
        $conexion=null;
        return $respuesta;
    }

    if($sentencia->rowCount()>0){
        $respuesta["usuario"]=$sentencia->fetch(PDO::FETCH_ASSOC);
        session_name("API_libreria");
        session_start();
        $respuesta["api_session"]=session_id();
        $_SESSION["usuario"]=$respuesta["usuario"]["lector"];
        $_SESSION["clave"]=$respuesta["usuario"]["clave"];
        $_SESSION["tipo"]=$respuesta["usuario"]["tipo"];

        $_SESSION["ult_accion"]=time();
        if($sentencia["usuario"]["tipo"]=="normal"){
            header("Location:index.html");
        }else{
            header("Location:admin/gest_libros.php");
        }
        exit();      
    }else{
       $respuesta["mensaje"]="El usuario no se encuentra en la BD";
    }
    $sentencia=null;
    $conexion=null;
    return $respuesta;
}

function logueado($usuario, $clave){
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
       
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
        return $respuesta;
    }

    try{
        $consulta="SELECT * FROM usuarios WHERE lector=? AND clave=?";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute([$usuario, $clave]);
    }catch(PDOException $e){
        $respuesta["error"]="Imposible realizar la consulta desde login";
        $sentencia=null;
        $conexion=null;
        return $respuesta;
    }

    if($sentencia->rowCount()>0){
        $respuesta["usuario"]=$sentencia->fetch(PDO::FETCH_ASSOC);
    }else{
        $respuesta["mensaje"]="El usuario no se encuentra en la BD";
    }

    $sentencia=null;
    $conexion=null;
    return $respuesta;
}


?>