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

function login($usuario, $clave){
    try{
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD,
            array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));

    }catch(PDOException $e){
        $respuesta["error"] = "Imposible conectar desde login: " . $e->getMessage();
        return $respuesta;
    }

    try{
        $consulta = "SELECT * FROM usuarios WHERE usuario=? AND clave=?";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute([$usuario, $clave]);

    }catch(PDOException $e){
        $respuesta["error"] = "Imposible realizar la consulta desde login: " . $e->getMessage();
        $sentencia=null;
        $conexion=null;
        return $respuesta;
    }

    if($sentencia->rowCount()>0){
        $respuesta["usuario"] = $sentencia->fetch(PDO::FETCH_ASSOC);
        session_name("examen3_practicar");
        session_start();
        $_SESSION["usuario"] = $respuesta["usuario"]["usuario"];
        $_SESSION["clave"] = $respuesta["usuario"]["clave"];
        $_SESSION["nombre"] = $respuesta["usuario"]["nombre"];
        $_SESSION["id"] = $respuesta["usuario"]["id"];

        $respuesta["api_session"] = session_id();

    }else{
        $respuesta["mensaje"] = "El usuario no se encuentra registrado en la BD";
    }
    $sentencia=null;
    $conexion=null;
    return $respuesta;
}



function obtener_horarios(){
    try{
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, 
            array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));

    }catch(PDOException $e){
        $respuesta["error"] = "Imposible conectar:" . $e->getMessage();
        return $respuesta;
    }

    try{
        $consulta = "SELECT * FROM usuarios";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute();
    }catch(PDOException $e){
        $respuesta["error"] = "Imposible realizar la consultaa: " . $e->getMessage();
        $sentencia = null;
        $conexion=null;
        return $respuesta;
    }

    $respuesta["usuarios"]=$sentencia->fetchAll(PDO::FETCH_ASSOC);

    $sentencia=null;
    $conexion=null;
    return $respuesta;
}

?>
