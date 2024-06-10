<?php
require "config_bd.php";

function conexion_pdo()
{
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
        
        $respuesta["mensaje"]="Conexi&oacute;n a la BD realizada con &eacute;xito";
        
        $conexion=null;
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
    }
    return $respuesta;
}


function conexion_mysqli()
{
  
    try
    {
        $conexion=mysqli_connect(SERVIDOR_BD,USUARIO_BD,CLAVE_BD,NOMBRE_BD);
        mysqli_set_charset($conexion,"utf8");
        $respuesta["mensaje"]="Conexi&oacute;n a la BD realizada con &eacute;xito";
        mysqli_close($conexion);
    }
    catch(Exception $e)
    {
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
    }
    return $respuesta;
}

function login($lector, $clave){
    try{
        $conexion = new PDO("mysqli:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQLI_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    }catch(PDOException $e){
        $respuesta["error"] = "Imposible conectar:" . $e->getMessage();
    }

    try{
        $consulta = "SELECT * FROM usuarios WHERE lector = ? AND clave = ?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia -> execute([$lector, $clave]);
    }catch(PDOException $e){
        $sentencia = null;
        $conexion = null;
        $respuesta["error"] = "Imposible realizar la consulta: " . $e->getMessage();
    }

    if($sentencia -> rowCount() > 0){
        // Inicio de sesiones
        session_name("examen-practicar");
        session_start();
        $respuesta["usuario"] = $sentencia->fetch(PDO::FETCH_ASSOC);
        $respuesta["api_session"] = session_id();
        $_SESSION["usuario"] = $respuesta["usuario"]["lector"];
        $_SESSION["clave"] = $respuesta["usuario"]["clave"];
        $_SESSION["tipo"] = $respuesta["usuario"]["tipo"];
    }else{
        $respuesta["mensaje"] = "El usuario no se encuentra en la BD";
    }
    $conexion = null;
    $sentencia = null;
    return $respuesta;
}

function logueado($lector, $clave){
    try{
        $conexion = new PDO("mysqli:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQLI_ATTR_INIT_COMMAND => "SET NAMES 'utf8'")) ;

    }catch(PDOException $e){
        $respuesta["error"] = "Imposible conectar:" . $e->getMessage();
    }

    try{
        $consulta = "SELECT * FROM usuarios WHERE lector = ? AND clave = ?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$lector, $clave]);
    }catch(PDOException $e){
        $sentencia = null;
        $conexion = null;
        $respuesta["error"] = "Imposible realizar la consulta:" . $e->getMessage();
    }
}










?>

