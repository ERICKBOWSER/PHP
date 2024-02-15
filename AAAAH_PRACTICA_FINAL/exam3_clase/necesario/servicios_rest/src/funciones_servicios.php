<?php
require "config_bd.php";

function login($usuario, $clave){
    try{
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
    }catch(PDOException $e){
        $respuesta["error"] = "Imposible conectar en LOGIN: " . $e->getMessage();
        return $respuesta;
    }

    try{
        $consulta = "SELECT * FROM usuarios WHERE usuario=? AND clave=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$usuario, $clave]);
    }catch(PDOException $e){
        $respuesta["error"] = "Imposible realizar la consulta en LOGIN: " . $e->getMessage();
        $sentenia=null;
        $conexion=null;
        return $respuesta;
    }
    // UNA VEZ REALIZADA LA CONEXIÓN...
    // CREAMOS LA SESSION Y ASIGNAMOS CADA VALOR A LA SESIÓN QUE LE CORRESPONDE
    if($sentencia->rowCount()>0){
        $respuesta["usuario"] = $sentencia->fetch(PDO::FETCH_ASSOC);
        session_name("Examen3_clase");
        session_start();
        $_SESSION["usuario"] = $respuesta["usuario"]["usuario"];
        $_SESSION["clave"] = $respuesta["usuario"]["clave"];
        $_SESSION["tipo"] = $respuesta["usuario"]["tipo"];
        $respuesta["api_session"] = session_id();
    }else{
        $respuesta["mensaje"] = "El usuario no se encuentra registrado en la BD en LOGIN";
    }
    $sentencia=null;
    $conexion=null;
    return $respuesta;
}

function logueado($usuario, $clave){
    try{
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
    }catch(PDOException $e){
        $respuesta["error"] = "Imposible conectar en LOGUEADO: " . $e->getMessage();
        return $respuesta;
    }

    try{
        $consulta = "SELECT * FROM usuarios WHERE usuario=? AND clave=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$usuario, $clave]);
    }catch(PDOException $e){
        $respuesta["error"] = "Imposible realizar la consulta en LOGUEADO: " . $e->getMessage();
        $sentenia=null;
        $conexion=null;
        return $respuesta;
    }
    // UNA VEZ REALIZADA LA CONEXIÓN...
    // CREAMOS LA SESSION Y ASIGNAMOS CADA VALOR A LA SESIÓN QUE LE CORRESPONDE
    if($sentencia->rowCount()>0){
        $respuesta["usuario"] = $sentencia->fetch(PDO::FETCH_ASSOC);
    }else{
        $respuesta["mensaje"] = "El usuario no se encuentra registrado en la BD en LOGIN";
    }
    $sentencia=null;
    $conexion=null;
    return $respuesta;
}




function insertar_grupo($datos){
    try{
        $conexion = new PDO("mysql:host=".SERVIDOR_BD.";dbname".NOMBRE_BD, USUARIO_BD, CLAVE_BD,
            array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));

    }catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
        return $respuesta;
    }

    try{
        $consulta="INSERT INTO horario_lectivo (usuario, dia, hora, grupo) VALUES(?,?,?,?)";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute($datos);
    }catch(PDOException $e){
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

function borrar_grupo($id_horario){
    try{
        $conexion = new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD, USUARIO_BD, CLAVE_BD,
            array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
    }catch(PDOException $e){
        $respuesta["error"]="Imposible conectar en borrar_grupo: ".$e->getMessage();
        return $respuesta;
    }

    try{
        $consulta = "DELETE FROM horario_lectivo WHERE id_horario=?";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute([$id_horario]);
    }catch(PDOException $e){
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
