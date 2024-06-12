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
        session_name("API_Exam4_23_24");
        session_start();
        $_SESSION["usuario"]=$respuesta["usuario"]["usuario"];
        $_SESSION["clave"]=$respuesta["usuario"]["clave"];
        $_SESSION["tipo"]=$respuesta["usuario"]["tipo"];
        $respuesta["api_session"]=session_id();
    }
    else
    {
        $respuesta["mensaje"]="Usuario no se encuentra regis. en la BD";
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
        $respuesta["mensaje"]="Usuario no se encuentra regis. en la BD";
    }

    $sentencia=null;
    $conexion=null;
    return $respuesta;
}

function obtener_alumnos()
{
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
        
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
        return $respuesta;
    }

    try{
        $consulta="select * from usuarios where tipo='alumno'";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute();

    }
    catch(PDOException $e){

        $respuesta["error"]="Imposible conectar:".$e->getMessage();
        $sentencia=null;
        $conexion=null;
        return $respuesta;
    }

    
    $respuesta["alumnos"]=$sentencia->fetchAll(PDO::FETCH_ASSOC);
        
    
    

    $sentencia=null;
    $conexion=null;
    return $respuesta;
}

function obtener_notas_alumno($cod_alu)
{
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
        
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
        return $respuesta;
    }

    try{
        $consulta="select asignaturas.cod_asig,asignaturas.denominacion, notas.nota from asignaturas, notas where asignaturas.cod_asig=notas.cod_asig and notas.cod_usu=?";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute([$cod_alu]);

    }
    catch(PDOException $e){

        $respuesta["error"]="Imposible conectar:".$e->getMessage();
        $sentencia=null;
        $conexion=null;
        return $respuesta;
    }

    
    $respuesta["notas"]=$sentencia->fetchAll(PDO::FETCH_ASSOC);
        
    
    

    $sentencia=null;
    $conexion=null;
    return $respuesta;
}

function obtener_notas_no_eval_alumno($cod_alu)
{
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
        
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
        return $respuesta;
    }

    try{
        $consulta="select * from asignaturas where cod_asig not in (select asignaturas.cod_asig from asignaturas, notas where asignaturas.cod_asig=notas.cod_asig and notas.cod_usu=?)";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute([$cod_alu]);

    }
    catch(PDOException $e){

        $respuesta["error"]="Imposible conectar:".$e->getMessage();
        $sentencia=null;
        $conexion=null;
        return $respuesta;
    }

    
    $respuesta["notas"]=$sentencia->fetchAll(PDO::FETCH_ASSOC);
        
    
    

    $sentencia=null;
    $conexion=null;
    return $respuesta;
}

function quitar_nota($datos)
{
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
        
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
        return $respuesta;
    }

    try{
        $consulta="delete from notas where cod_asig=? and cod_usu=?";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute($datos);

    }
    catch(PDOException $e){

        $respuesta["error"]="Imposible conectar:".$e->getMessage();
        $sentencia=null;
        $conexion=null;
        return $respuesta;
    }

    
    $respuesta["mensaje"]="Asignatura descalificada con éxito";
        
    
    

    $sentencia=null;
    $conexion=null;
    return $respuesta;
}

function cambiar_nota($datos)
{
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
        
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
        return $respuesta;
    }

    try{
        $consulta="update notas set nota=? where cod_asig=? and cod_usu=?";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute($datos);

    }
    catch(PDOException $e){

        $respuesta["error"]="Imposible conectar:".$e->getMessage();
        $sentencia=null;
        $conexion=null;
        return $respuesta;
    }

    
    $respuesta["mensaje"]="Asignatura calificada con éxito";
        
    
    

    $sentencia=null;
    $conexion=null;
    return $respuesta;
}

function poner_nota($datos)
{
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
        
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
        return $respuesta;
    }

    try{
        $consulta="insert into notas (cod_asig,cod_usu,nota) values (?,?,0.0)";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute($datos);

    }
    catch(PDOException $e){

        $respuesta["error"]="Imposible conectar:".$e->getMessage();
        $sentencia=null;
        $conexion=null;
        return $respuesta;
    }

    
    $respuesta["mensaje"]="Asignatura calificada con éxito";
        
    
    

    $sentencia=null;
    $conexion=null;
    return $respuesta;
}
?>
