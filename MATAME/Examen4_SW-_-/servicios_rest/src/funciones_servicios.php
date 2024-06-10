<?php

function login($usuario, $clave){
    try{
        $conexion = new PDO("mysql:host=".SERVIDOR_BD.";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
    }catch(PDOException $e){
        $respuesta["error"] = "Imposible conectar a la bbdd desde LOGIN: ".$e->getMessage();
        return $respuesta;
    }

    try{
        $consulta="SELECT * FROM usuarios WHERE usuario=? AND clave=?";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute([$usuario, $clave]);
    }catch(PDOException $e){
        $respuesta["error"]="Imposible realizar la consulta SQL desde LOGIN: ".$e->getMessage();
        // BORRAMOS LOS DATOS DE LA CONEXION Y LA CONSULTA
        $sentencia=null;
        $conexion=null;
        return $respuesta;
    }

    // rowCount() DEVUELVE EL NÚMERO DE FILAS DE LA SENTENCIA SQL
    if($sentencia->rowCount()>0){
        $respuesta["usuario"]=$sentencia->fetch(PDO::FETCH_ASSOC);
        session_name("API_Exam_23_24");
        session_start();
        $_SESSION["usuario"]=$respuesta["usuario"]["usuario"];
        $_SESSION["clave"]=$respuesta["usuario"]["clave"];
        $_SESSION["tipo"]=$respuesta["usuario"]["tipo"];
        $respuesta["api_session"]=session_id();
    }else{
        $respuesta["mensaje"]="Usuario no se encuentra registrado en la BBDD LOGIN";
    }

    $sentencia=null;
    $conexion=null;
    return $respuesta;
}

function logueado($usuario, $clave){
    // CONEXION CON LA BBDD
    try{
        $conexion = new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
    }catch(PDOException $e){
        $respuesta["error"] = "Imposible conectar con la bbdd desde LOGUEADO: " .$e->getMessage();
        return $respuesta;
    }

    // REALIZAMOS LA CONSULTA SQL
    try{
        $consulta="SELECT * FROM usuario WHERE usuario=? AND clave=?";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute([$usuario, $clave]);
    }catch(PDOException $e){
        $respuesta["error"]="Imposible conectar: " . $e->getMessage();
        $sentencia=null;
        $conexion=null;
        return $respuesta;
    }

    if($sentencia->rowCount()>0){
        $respuesta["usuario"] = $sentencia->fetch(PDO::FETCH_ASSOC); // DEVUELVE UN ARRAY INDEXADO POR LOS NOMBRES DE LAS COLUMNAS
    }else{
        $respuesta["mensaje"]="Usuario no se encuentra registrado en la BD desde LOGUEADO";
    }

    $sentencia=null;
    $conexion=null;
    return $respuesta;
}

function obtener_alumnos(){
    try{
        $conexion = new PDO("mysql:host=" .SERVIDOR_BD.";dbname=".NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
    }catch(PDOException $e){
        $respuesta["error"] = "Imposible conectar desde OBTENER_ALUMNOS: ".$e->getMessage();
        return $respuesta;
    }

    try{
        $consulta="SELECT * FROM usuarios WHERE tipo='alumno'";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute();
    }catch(PDOException $e){
        $respuesta["error"]="Imposible conectar desde consulta OBTENER_ALUMNOS: ".$e->getMessage();
        $sentencia=null;
        $conexion=null;
        return $respuesta;
    }

    $respuesta["alumnos"]=$sentencia->fetchAll(PDO::FETCH_ASSOC); // Devuelve un array que contiene todas las filas del conjunto de resultados

    // RESETEAMOS 
    $sentencia=null;
    $conexion=null;
    return $respuesta;
}

function obtener_notas_alumno($cod_alu){
    try{
        $conexion = new PDO("mysql:host=" .SERVIDOR_BD.";dbname=".NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
    }catch(PDOException $e){
        $respuesta["error"] = "Imposible conectar desde OBTENER_NOTAS_ALUMNO: ".$e->getMessage();
        return $respuesta;
    }

    try{
        $consulta="SELECT asignaturas.cod_asig, asignaturas.denominacion, notas.nota FROM asignaturas, notas WHERE asignaturas.cod_asig=notas.cod_asig AND notas.cod_usu=?";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute([$cod_alu]); // PASAMOS EL cod_alu PARA EXTRAER LA NOTA DEL USUARIO QUE TENGA ESE ID
    }catch(PDOException $e){
        $respuesta["error"]="Imposible realizar consulta desde OBTENER_NOTAS_ALUMNO: ".$e->getMessage();
        $sentencia=null;
        $conexion=null;
        return $respuesta; 
    }

    $respuesta["notas"]=$sentencia->fetchAll(PDO::FETCH_ASSOC); // Devuelve un array que contiene todas las filas

    // RESETEAMOS
    $sentencia=null;
    $conexion=null;
    return $respuesta;
}

function obtener_notas_no_eval_alumno($cod_alu){
    try{
        $conexion = new PDO("mysql:host=".SERVIDOR_BD.";dbname=". NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
    }catch(PDOException $e){
        $respuesta["error"] = "Imposible conectar con la bd desde OBTENER_NOTAS_NO_EVAL_ALUMNO: ".$e->getMessage();
        return $respuesta;
    }

    try{
        // EN ESTA CONSULTA COGEMOS TODOS LOS ALUMOS QUE NO ESTEN EN asignaturas y notas
        $consulta="SELECT * FROM asignaturas WHERE cod_asig NOT IN(SELECT asignaturas.cod_asig FROM asignaturas, notas WHERE asignaturas.cod_asig=notas.cod_asig AND notas.cod_usu=?)";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute([$cod_alu]);
    }catch(PDOException $e){
        $respuesta["error"]="Imposible conectar desde la consulta sql OBTENER_NOTAS_NO_EVAL_ALUMNO: " .$e->getMessage();
        $sentencia=null;
        $conexion=null;
        return $respuesta;
    }

    $respuesta["notas"]=$sentencia->fetchAll(PDO::FETCH_ASSOC);

    $sentencia=null;
    $conexion=null;
    return $respuesta;
}

function quitar_nota($datos){
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
        
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar a la bd desde QUITAR_NOTA: ".$e->getMessage();
        return $respuesta;
    }

    try{
        $consulta="DELETE FROM notas WHERE cod_asig=? AND cod_usu=?";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute($datos);
    }catch(PDOException $e){
        $respuesta["error"]="Imposible realizar la consulta SQL desde QUITAR_NOTAS: " .$e->getMessage();
        $sentencia=null;
        $conexion=null;
        return $respuesta;
    }

    $respuesta["mensaje"]="Asignatura descalificada con éxito desde QUITAR_NOTA";

    $sentencia=null;
    $conexion=null;
    return $respuesta;
}

function cambiar_nota($datos){
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
        
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar desde la bd CAMBIAR_NOTA: ".$e->getMessage();
        return $respuesta;
    }

    try{
        $consulta="UPDATE notas SET nota=? WHERE cod_asig=? AND cod_usu=?";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute($datos);
    }catch(PDOException $e){
        $respuesta["error"]="Imposible realizar la consulta SQL desde CAMBIAR_NOTA: ".$e->getMessage();
        $sentencia=null;
        $conexion=null;
        return $respuesta;
    }

    $respuesta["mensaje"]="Asignatura calificada con éxito desde CAMBIAR_NOTA";

    $sentencia=null;
    $conexion=null;
    return $respuesta;

}

function poner_nota($datos){
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
        
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar con la bd desde PONER_NOTA: ".$e->getMessage();
        return $respuesta;
    }

    try{
        $consulta="INSERT INTO notas(cod_asig, cod_usu, nota) VALUES (?,?,0.0)";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute($datos);
    }catch(PDOException $e){
        $respuesta["error"]="Imposible realizar la consulta SQL desde PONER_NOTA: ".$e->getMessage();
        $sentencia=null;
        $conexion=null;
        return $respuesta;
    }

    $respuesta["mensaje"]="Asignatura calificada con éxito desde PONER_NOTA";

    $sentencia=null;
    $conexion=null;
    return $respuesta;

}



?>