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
        $respuesta["error"]="Imposible realizar la consulta desde LOGIN";
        $sentencia=null;
        $conexion=null;
        return $respuesta;
    }

    // IMPRESCINDIBLE HACER ESTO
    if($sentencia->rowCount()>0){
        $respuesta["usuario"]=$sentencia->fetch(PDO::FETCH_ASSOC);
        session_name("API_examen_libreria");
        session_start();
        $respuesta["api_session"]=session_id();
        $_SESSION["usuario"]=$respuesta["usuario"]["lector"];
        $_SESSION["clave"]=$respuesta["usuario"]["clave"];
        $_SESSION["tipo"]=$respuesta["usuario"]["tipo"];
    }else{
        $respuesta["mensaje"]="El usuario no es encuentra en la BBDD";        
    }

    // CERRAMOS CONSULTA
    $sentencia=null;
    $conexion=null;
    return $respuesta;
}

// ESTO LO NECESITAMOS SOBRETODO PARA SEGURIDAD, PARA EL CONTROL DE TIEMPO
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
        $respuesta["error"]="Imposible realizar la consulta desde LOGUEADO: ".$e->getMessage();
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