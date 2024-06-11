<?php 

require "config_bd.php";

function login($usuario, $clave){
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
       
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar con la BD desde LOGIN: ".$e->getMessage();
        return $respuesta;
    }

    try{
        $consulta="SELECT * FROM usuarios WHERE usuario=? AND clave=?";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute([$usuario, $clave]);
    }catch(PDOException $e){
        $respuesta["error"]="Imposible realizar la consulta desde LOGIN: ".$e->getMessage();
        $sentencia=null;
        $conexion=null;
        return $respuesta;
    }

    if($sentencia->rowCount()>0){
        $respuesta["usuario"]=$sentencia->fetch(PDO::FETCH_ASSOC);
        session_name("API_examen2");
        session_start();
        $respuesta["api_session"]=session_id();
        $_SESSION["usuario"]=$respuesta["usuario"]["usuario"];
        $_SESSION["clave"]=$respuesta["usuario"]["clave"];
        
    }else{
        $respuesta["mensaje"]="El usuario no se encuentra en la BD desde LOGUEADO";
    }

    // AL TERMINAR LIMPIAMOS 
    $sentencia=null;
    $conexion=null;
    return $respuesta;
}

function logueado($usuario, $clave){
    try{
        $conexion = new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
    }catch(PDOException $e){
        $respuesta["error"]="Imposible conectar con la bbdd desde LOGUEADO: ".$e->getMessage();
        return $respuesta;
    }

    try{
        $consulta="SELECT * FROM usuarios WHERE usuario=? AND clave=?";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute([$usuario, $clave]);
    }catch(PDOException $e){
        $respuesta["error"]="Imposible realizar la consulta desde LOGUEADO. Error: ".$e->getMessage();
        $sentencia=null;
        $conexion=null;
        return $respuesta;
    }

    // rowCount() DEVUELVE EL NÚMERO DE FILAS DE LA SENTENCIA SQL
    if($sentencia->rowCount()>0){
        $respuesta["usuario"]=$sentencia->fetch(PDO::FETCH_ASSOC); // DEVUELVE EL ARRAY INDEXADO O FALSE
    }else{
        $respuesta["mensaje"]="El usuario no se encuentra en la BD desde LOGUEADO";
        
    }
    $sentencia=null;
    $conexion=null;
    return $respuesta;

}

function obtener_profesores(){
    try{
        $conexion = new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
    }catch(PDOException $e){
        $respuesta["error"]="Imposible conectar con la bbdd desde LOGUEADO: ".$e->getMessage();
        return $respuesta;
    }

    try{
        $consulta="SELECT * FROM usuarios";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute();
    }catch(PDOException $e){
        $respuesta["error"]="Imposible realizar la consulta desde OBTENER_PROFESORES: ".$e->getMessage();
        $sentencia=null;
        $conexion=null;
        return $respuesta;
    }

    // LO ALMACENAMOS PARA LUEGO RECORRERLO Y MOSTRARLO POR PANTALLA
    $respuesta["profesores"]=$sentencia->fetchAll(PDO::FETCH_ASSOC);// DEVUELVE UN ARRAY INDEXADO DE TODOS LOS ELEMENTOS O UN ARRAY VACÍO
    
    $sentencia=null;
    $conexion=null;
    return $respuesta;
}

function obtenerHorario($id_usuario){
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
        return $respuesta;
    }

    try{
        $consulta="SELECT horario_lectivo.*, grupos.nombre FROM horario_lectivo, grupos WHERE horario_lectivo.grupo=grupos.id_grupo AND horario_lectivo.usuario=?";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute([$id_usuario]); 
    }catch(PDOException $e){
        $respuesta["error"]="Imposible realizar la consulta desde OBTERNERHORARIO: ".$e->getMessage();
        $sentencia=null;
        $conexion=null;
        return $respuesta;
    }

    $respuesta["horario"]=$sentencia->fetchAll(PDO::FETCH_ASSOC);

    $sentencia=null;
    $conexion=null;
    return $respuesta;
}

function obtener_horario_dia_hora($datos){
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
        return $respuesta;
    }

    try{
        $consulta="SELECT horario_lectivo.id_horario, grupos.nombre FROM horario_lectivo, grupos WHERE horario_lectivo.grupo=grupos.id_grupo AND horario_lectivo.usuario=? AND horario_lectivo.dia=? AND horario_lectivo.hora=?";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute($datos);
    }catch(PDOException $e){
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

function obtener_horario_no_dia_hora($datos){
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
        return $respuesta;
    }

    try{
        $consulta="SELECT * FROM grupos WHERE id_grupo NOT IN(SELECT grupos.id_grupo FROM horario_lectivo, grupos WHERE horario_lectivo.grupo=grupos.id_grupo AND horario_lectivo.usuario=? AND horario_lectivo.dia=? AND horario_lectivo.hora=?)";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute($datos);
    }catch(PDOException $e){
        $respuesta["error"]="Imposible realizar la consulta desde obtener_horario_no_dia_hora. ".$e->getMessage();
        $sentencia=null;
        $conexion=null;
        return $respuesta;
    }

    $respuesta["horario"]=$sentencia->fetchAll(PDO::FETCH_ASSOC);

    $sentencia=null;
    $conexion=null;
    return $respuesta;
}

function insertar_grupo($datos){
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
        return $respuesta;
    }

    try{
        $consulta="INSERT INTO horario_lectivo (usuario, dia, hora, grupo) VALUES(?,?,?,?)";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute($datos);
    } catch(PDOException $e){
        $respuesta["error"]="Imposible realizar la consulta desde insertar_grupo:".$e->getMessage();
        $sentencia=null;
        $conexion=null;
        return $respuesta;
    }

    $respuesta["mensaje"]="Grupo insertado correctamente";

    $sentencia=null;
    $conexion=null;
    return $respuesta;
}

function borrar_grupo($id_grupo){
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
        return $respuesta;
    }

    try{
        $consulta="DELETE FROM horario_lectivo WHERE id_horario=?";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute([$id_grupo]);
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