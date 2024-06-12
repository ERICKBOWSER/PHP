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
        $respuesta["error"]="Imposible realizar la consulta:".$e->getMessage();
        $sentencia=null;
        $conexion=null;
        return $respuesta;
    }

    if($sentencia->rowCount()>0)
    {
        $respuesta["usuario"]=$sentencia->fetch(PDO::FETCH_ASSOC);
        session_name("API_prueba");
        session_start();
        $respuesta["api_session"]=session_id();
        $_SESSION["user"]=$respuesta["usuario"]["usuario"];
        $_SESSION["pass"]=$respuesta["usuario"]["clave"];
        $_SESSION["type"]=$respuesta["usuario"]["tipo"];
    }
    else
        $respuesta["mensaje"]="El usuario no se encuentra en la BD";

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
        $consulta="SELECT * FROM usuarios WHERE usuario=? AND clave=?";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute([$usuario, $clave]);
    }catch(PDOException $e){
        $respuesta["error"]="Error al realizar la consulta. ".$e->getMessage();
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

function notas_alumno($cod_alu){
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
       
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
        return $respuesta;
    }

    try{
        $consulta="SELECT asignaturas.cod_asig, asignaturas.denominacion, notas.nota FROM asignaturas, notas WHERE asignaturas.cod_asig=notas.cod_asig AND cod_usu=?";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute([$cod_alu]);
    }catch(PDOException $e){
        $respuesta["error"]="Error al realizar la consulta desde obtener_alumno";
        $sentencia=null;
        $conexion=null;
        return $respuesta;
    }

    $respuesta["notas"]=$sentencia->fetchAll(PDO::FETCH_ASSOC);

    $sentencia=null;
    $conexion=null;
    return $respuesta;
}

function obtener_alumnos(){
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
       
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
        return $respuesta;
    }
    try{
        $consulta="SELECT * FROM usuarios WHERE tipo='alumno'";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute();
    }catch(PDOException $e){
        $respuesta["error"]="Error al realizar la consulta desde obtener_alumnos";
        $sentencia=null;
        $conexion=null;
        return $respuesta;
    }

    $respuesta["alumnos"]=$sentencia->fetchAll(PDO::FETCH_ASSOC);
    
    $sentencia=null;
    $conexion=null;
    return $respuesta;

}

function obtener_notas_alumno($cod_usu){
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
       
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
        return $respuesta;
    }

    try{
        $consulta="SELECT notas.cod_asig, asignaturas.denominacion, notas.nota FROM notas, asignaturas WHERE notas.cod_asig=asignaturas.cod_asig AND notas.cod_usu=?";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute([$cod_usu]);
    }catch(PDOException $e){
        $respuesta["error"]="Error al realizar la consulta desde obtener_notas_alumon";
        $sentencia=null;
        $conexion=null;
        return $respuesta;
    }

    $respuesta["verNotas"]=$sentencia->fetchAll(PDO::FETCH_ASSOC);
    $sentencia=null;
    $conexion=null;
    return $respuesta;
}
