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
        session_name("Examen2_23_24_SW");
        session_start();
        $_SESSION["usuario"]=$respuesta["usuario"]["usuario"];
        $_SESSION["clave"]=$respuesta["usuario"]["clave"];
        $_SESSION["tipo"]=$respuesta["usuario"]["tipo"];
        $respuesta["api_session"]=session_id();

    }
    else
    {
        $respuesta["mensaje"]="El usuario no se encuentra registrado en la BD";
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
        $respuesta["error"]="Imposible realizar la consulta:".$e->getMessage();
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
        $respuesta["mensaje"]="El usuario no se encuentra registrado en la BD";
    }

    $sentencia=null;
    $conexion=null;
    return $respuesta;
}

function obtener_usuarios()
{
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
        return $respuesta;
    }

    try{
        $consulta="select * from usuarios";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute();
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible realizar la consulta:".$e->getMessage();
        $sentencia=null;
        $conexion=null;
        return $respuesta;
    }
    
    
    $respuesta["usuarios"]=$sentencia->fetchAll(PDO::FETCH_ASSOC);
       
    

    $sentencia=null;
    $conexion=null;
    return $respuesta;
}
function obtener_horario($id_usuario)
{
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
        return $respuesta;
    }

    try{
        $consulta="SELECT horario_lectivo.*, grupos.nombre FROM horario_lectivo,grupos WHERE horario_lectivo.grupo=grupos.id_grupo and horario_lectivo.usuario=?";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute([$id_usuario]);
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible realizar la consulta:".$e->getMessage();
        $sentencia=null;
        $conexion=null;
        return $respuesta;
    }
    
    
    $respuesta["horario"]=$sentencia->fetchAll(PDO::FETCH_ASSOC);
       
    

    $sentencia=null;
    $conexion=null;
    return $respuesta;
}

function obtener_horario_dia_hora($datos)
{
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
        return $respuesta;
    }

    try{
        $consulta="SELECT horario_lectivo.id_horario, grupos.nombre FROM horario_lectivo,grupos WHERE horario_lectivo.grupo=grupos.id_grupo and horario_lectivo.usuario=? and horario_lectivo.dia=? and horario_lectivo.hora=?";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute($datos);
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible realizar la consulta:".$e->getMessage();
        $sentencia=null;
        $conexion=null;
        return $respuesta;
    }
    
    
    $respuesta["horario"]=$sentencia->fetchAll(PDO::FETCH_ASSOC);
       
    

    $sentencia=null;
    $conexion=null;
    return $respuesta;
}

function obtener_horario_no_dia_hora($datos)
{
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
        return $respuesta;
    }

    try{
        $consulta="select * from grupos where id_grupo not in (SELECT grupos.id_grupo FROM horario_lectivo,grupos WHERE horario_lectivo.grupo=grupos.id_grupo and horario_lectivo.usuario=? and horario_lectivo.dia=? and horario_lectivo.hora=?)";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute($datos);
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible realizar la consulta:".$e->getMessage();
        $sentencia=null;
        $conexion=null;
        return $respuesta;
    }
    
    
    $respuesta["horario"]=$sentencia->fetchAll(PDO::FETCH_ASSOC);
       
    

    $sentencia=null;
    $conexion=null;
    return $respuesta;
}

function insertar_grupo($datos)
{
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
        return $respuesta;
    }

    try{
        $consulta="insert into horario_lectivo (usuario,dia,hora,grupo) values(?,?,?,?)";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute($datos);
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible realizar la consulta:".$e->getMessage();
        $sentencia=null;
        $conexion=null;
        return $respuesta;
    }
    
    
    $respuesta["mensaje"]="Grupo insertado correctamente";
       
    

    $sentencia=null;
    $conexion=null;
    return $respuesta;
}

function borrar_grupo($id_horario)
{
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
        return $respuesta;
    }

    try{
        $consulta="delete from horario_lectivo where id_horario=?";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute([$id_horario]);
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible realizar la consulta:".$e->getMessage();
        $sentencia=null;
        $conexion=null;
        return $respuesta;
    }
    
    
    $respuesta["mensaje"]="Grupo borrado correctamente";
       
    

    $sentencia=null;
    $conexion=null;
    return $respuesta;
}
?>
