<?php
require "config_bd.php";

function login($usuario, $clave){
    try{
        $conexion = new PDO("mysql: host=" . SERVIDOR_BD . "; dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD,
            array(PDO::MYSQL_ATTR_INIT_COMMAND=> "SET NAMES 'utf8'"));
    }catch(PDOException $e){
        $respuesta["error"] = "Imposible conectar: " . $e->getMessage();
        return $respuesta;
    }

    try{
        $consulta = "SELECT * FROM usuarios WHERE usuario=? AND clave=?";
        $sentencia = $conexion->prepare($consulta);// preparamos la consulta
        $sentencia->execute([$usuario, $clave]); // Ejecutamos la consulta pasandole estos parametros

    }catch(PDOException $e){ // SI HAY ERROR ENVIAMOS UN MENSAJE DE ERROR Y PONEMOS LOS PARAMETROS EN NULL PARA BORRAR TODOS LOS DATOS PUESTOS ANTERIORMENTE
        $respuesta["error"] = "Imposible realizar la consulta: " . $e->getMessage();
        $sentencia = null;
        $conexion = null;
        return $respuesta;
    }

    if($sentencia -> rowCount()> 0){ // rowCount() DEVUELVE EL NÚMERO DE LINEAS 
        $respuesta["usuario"] = $sentencia->fetch(PDO::FETCH_ASSOC); // DEVUELVE UN ARRAY INDEXADO POR LOS NOMBRES
        
        // Creamos una sesión
        session_name("examen-practicar2");
        session_start();
        
        // LE PASAMOS EL ARRAY DE LA $respuesta QUE CONTIENE LOS DATOS DEL USUARIO PARA POSTERIORMENTE ALMACENARLO EN SESIONES
        $_SESSION["usuario"] =$respuesta["usuario"]["usuario"];
        $_SESSION["clave"] = $respuesta["usuario"]["clave"];
        $_SESSION["tipo"] = $respuesta["usuario"]["tipo"];
        $respuesta["api_session"] = session_id(); // session_id SE USA PARA OBTENER EL ID DE LA SESIÓN ACTUAL

    }else{
        $respuesta["mensaje"] = "El usuario no se encuentra registrado en la BD";
    }

    $sentencia = null;
    $conexion = null;
    return $respuesta;
}

// ESTO ES POR SEGURIDAD
function logueado($usuario, $clave){
    // CONECTAMOS CON LA BBDD
    try{
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, 
            array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));

    }catch(PDOException $e){
        $respuesta["error"] = "Imposible conectar:" . $e->getMessage();
        return $respuesta;
    }

    // DESPUÉS DE REALIZAR LA CONEXIÓN PASAMOS A REALIZAR LAS CONSULTAS

    try{
        $consulta = "SELECT * FROM usuarios WHERE lector=? AND clave=?";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute([$usuario][$clave]);

    }catch(PDOException $e){
        $respuesta["error"] = "Imposible realizar la consulta:" . $e->getMessage();
        $sentencia=null;
        $conexion=null;

        return $respuesta;
    }

    if($sentencia->rowCount()>0){
        $respuesta["usuario"] = $sentencia->fetch(PDO::FETCH_ASSOC);
        // NO HACE FALTAR CREAR SESIONES PORQUE YA SE CREARON EN EL login()
    }else{
        $respuesta["mensaje"]="El usuario no se encuentra registrado en la BD";
    }
    $sentencia  =null;
    $conexion=null;
    return $respuesta;

}

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


?>
