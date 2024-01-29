<?php

require __DIR__ . '/http://localhost/Servicios_Web/Ejercicio1/servicios_rest';

define("SERVIDOR_BD", "localhost");
define("USUARIO_BD", "jose");
define("CLAVE_BD", "josefa");
define("NOMBRE_BD", "bd_tienda");

function login($usuario, $clave){
    try{
        $conexion = new PDO("mysqli:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD , USUARIO_BD , CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

    }catch(PDOException $e){
        $respuesta["mensaje_error"] = "No se ha podido conectar a la base de datos: " . $e->getMessage();
        return $respuesta;
    }

    try{
        $consulta = "SELECT * FROM usuarios WHERE usuario=? AND clave=?";
        $sentencia = $conexion -> prepare($consulta);
        $sentencia -> execute($usuario, $clave);
    }catch(PDOException $e){
        $sentencia = null;
        $conexion = null;
        return array("mensaje_error", "No se ha podido conectar a la base de datos: " . $e->getMessage());
    }
    if($sentencia->rowCount()>0){
        $respuesta["productos"] = $sentencia -> fetchAll(PDO::FETCH_ASSOC);
    }else{
        $respuesta["mensaje"] = "El usuaio no se encuentra en la BD";
    }

    $sentencia = null;
    $conexion = null;
    return $respuesta;
}

