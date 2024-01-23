<?php

require __DIR__ . '/http://localhost/Servicios_Web/Ejercicio1/servicios_rest';

define("SERVIDOR_BD", "localhost");
define("USUARIO_BD", "jose");
define("CLAVE_BD", "josefa");
define("NOMBRE_BD", "bd_tienda");

function obtenerProductos(){
    try{
        $conexion = new PDO("mysqli:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD , USUARIO_BD , CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

    }catch(PDOException $e){
        $respuesta["mensaje_error"] = "No se ha podido conectar a la base de datos: " . $e->getMessage();
        return $respuesta;
    }

    try{
        $consulta = "SELECT * FROM producto";
        $sentencia = $conexion -> prepare($consulta);
        $sentencia -> execute();
    }catch(PDOException $e){
        $sentencia = null;
        $conexion = null;
        return array("mensaje_error", "No se ha podido conectar a la base de datos: " . $e->getMessage());
    }

    $respuesta["productos"] = $sentencia -> fetchAll(PDO::FETCH_ASSOC);
    $sentencia = null;
    $conexion = null;
    return $respuesta;
}

function obtenerProducto($codigo){
    try{
        $conexion = new PDO("mysqli:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD . USUARIO_BD . CLAVE_BD . array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES"));

    }catch(PDOException $e){
        $respuesta["mensaje_error"] = "No se ha podido conectar a la base de datos: " . $e->getMessage();
        return $respuesta;
    }

    try{
        $consulta = "SELECT * FROM producto WHERE cod=?";
        $sentencia = $conexion -> prepare($consulta);
        $sentencia -> execute([$codigo]);
    }catch(PDOException $e){
        $sentencia = null;
        $conexion = null;
        return array("mensaje_error", "No se ha podido conectar a la base de datos: " . $e->getMessage());
    }

    if($sentencia -> rowCount()>0){
        $respuesta["producto"] = $sentencia -> fetch(PDO::FETCH_ASSOC);
    }else{
        $sentencia["productos"] = $sentencia -> fetch(PDO::FETCH_ASSOC);
    }
    $conexion = null;
    return $respuesta;    
}

function insertarProducto($datos){
    try{
        $conexion = new PDO("mysqli:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD . USUARIO_BD . CLAVE_BD . array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES"));

    }catch(PDOException $e){
        $respuesta["mensaje_error"] = "No se ha podido conectar a la base de datos: " . $e->getMessage();
        return $respuesta;
    }

    try{
        $consulta = "INSERT INTO producto(cod, nombre, nombre_corto, descripcion, PVP, familia) VALUES (?,?,?,?,?,?)";
        $sentencia = $conexion -> prepare($consulta);
        $sentencia -> execute([$datos]);
    }catch(PDOException $e){
        $sentencia = null;
        $conexion = null;
        return array("mensaje_error", "No se ha podido conectar a la base de datos: " . $e->getMessage());
    }
    $respuesta["mensaje"]= "El producto se ha insertado correctamente";
    
}

function actualizarProducto($datos){
    try{
        $conexion = new PDO("mysqli:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD . USUARIO_BD . CLAVE_BD . array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES"));

    }catch(PDOException $e){
        $respuesta["mensaje_error"] = "No se ha podido conectar a la base de datos: " . $e->getMessage();
        return $respuesta;
    }

    try{
        $consulta = "UPDATE producto SET nombre=?, nombre_corte=?, descripcion=?, PVP=?, familia=? WHERE cod=?";
        $sentencia = $conexion -> prepare($consulta);
        $sentencia -> execute([$datos]);
    }catch(PDOException $e){
        $sentencia = null;
        $conexion = null;
        return array("mensaje_error", "No se ha podido conectar a la base de datos: " . $e->getMessage());
    }
    $respuesta["mensaje"]= "El producto se ha insertado correctamente";
    
}

function borrarProducto($codigo){
    try{
        $conexion = new PDO("mysqli:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD . USUARIO_BD . CLAVE_BD . array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES"));

    }catch(PDOException $e){
        $respuesta["mensaje_error"] = "No se ha podido conectar a la base de datos: " . $e->getMessage();
        return $respuesta;
    }

    try{
        $consulta = "DELETE FROM producto WHERE cod=?";
        $sentencia = $conexion -> prepare($consulta);
        $sentencia -> execute([$codigo]);
    }catch(PDOException $e){
        $sentencia = null;
        $conexion = null;
        return array("mensaje_error" => "No se ha podido conectar a la base de datos: " . $e->getMessage());
    }
    if($sentencia->rowCount()>0){
        $respuesta["mensaje"]= "El producto se ha borrado correctamente";
    }else{
        $respuesta["mensaje"]= "El producto no se encontraba en la BD";
    }
    $sentencia=null;
    $conexion=null;
    return $respuesta;
    
}


function obtenerFamilias(){
    try{
        $conexion = new PDO("mysqli:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD , USUARIO_BD , CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

    }catch(PDOException $e){
        $respuesta["mensaje_error"] = "No se ha podido conectar a la base de datos: " . $e->getMessage();
        return $respuesta;
    }

    try{
        $consulta = "SELECT * FROM familia";
        $sentencia = $conexion -> prepare($consulta);
        $sentencia -> execute();
    }catch(PDOException $e){
        $sentencia = null;
        $conexion = null;
        return array("mensaje_error", "No se ha podido conectar a la base de datos: " . $e->getMessage());
    }

    $respuesta["familias"] = $sentencia -> fetchAll(PDO::FETCH_ASSOC);
    $sentencia = null;
    $conexion = null;
    return $respuesta;
}

function repetido($tabla, $columna, $valor){
    try{
        $conexion = new PDO("mysqli:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD , USUARIO_BD , CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

    }catch(PDOException $e){
        $respuesta["mensaje_error"] = "No se ha podido conectar a la base de datos: " . $e->getMessage();
        return $respuesta;
    }

    try{
        $consulta = "SELECT * FROM " . $tabla . " WHERE " . $columna . "=?";
        $sentencia = $conexion -> prepare($consulta);
        $sentencia -> execute($valor);
    }catch(PDOException $e){
        $sentencia = null;
        $conexion = null;
        return array("mensaje_error", "No se ha podido conectar a la base de datos: " . $e->getMessage());
    }

    $respuesta["repetido"] = ($sentencia -> rowCount()) > 0;
    $sentencia = null;
    $conexion = null;
    return $respuesta;
}