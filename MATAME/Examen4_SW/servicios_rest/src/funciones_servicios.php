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
        session_name("Examen4_SW_Rec_23_24");
        session_start();
        $respuesta["api_session"]=session_id();
        $_SESSION["user"]=$respuesta["usuario"]["usuario"];
        $_SESSION["pass"]=$respuesta["usuario"]["clave"];
        $_SESSION["type"]=$respuesta["usuario"]["tipo"];
    }
    else
        $respuesta["mensaje"]="El usuario no se encuentra en la BD";

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
        $respuesta["error"]="Imposible realizar la consulta desde LOGUEADO: ".$e->getMessage();
        $sentencia=null;
        $conexion=null;
        return $respuesta;
    }

    // rowCount() DEVUELVE EL NÚMERO DE FILAS DE LA SENTENCIA SQL
    if($sentencia->rowCount()>0){
        $respuesta["usuario"]=$sentencia->fetch(PDO::FETCH_ASSOC); // DEVUELVE EL ARRAY INDEXADO POR LOS NOMBRES DE LAS COLUMNAS
    }else{
        $respuesta["mensaje"]="El usuario no se encuentra en la BD desde LOGUEADO";
    }

    $sentencia=null;
    $conexion=null;
    return $respuesta;

}

function obtener_notas_alumno($cod_usu){
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
       
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar con la BD desde OBTENER_NOTAS_ALUMNO:".$e->getMessage();
        return $respuesta;
    }

    try{
        $consulta="SELECT asignaturas.cod_asig, asignaturas.denominacion, notas.nota FROM asignaturas, notas WHERE asignaturas.cod_asig=notas.cod_asig AND cod_usu=?";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute([$cod_usu]);
    }catch(PDOException $e){
        $respuesta["error"]="Imposible realizar la consulta: " . $e->getMessage();
        $sentencia=null;
        $conexion=null;
        return $respuesta;
    }

    $respuesta["notas"]=$sentencia->fetchAll(PDO::FETCH_ASSOC);

    $sentencia=null;
    $conexion=null;
    return $respuesta;
}

function obtener_alumnos(){
    try{
        $conexion = new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
    }catch(PDOException $e){
        $respuesta["error"]="Imposible conectar con la BD desde OBTENER_ALUMNOS: ".$e->getMessage();
        return $respuesta;
    }

    try{
        $consulta = "SELECT * FROM usuarios WHERE tipo='alumno'";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute();
    }catch(PDOException $e){
        $respuesta["error"]="Imposible realizar la consulta desde OBTENER_ALUMNOS: ".$e->getMessage();
        $sentencia=null;
        $conexion=null;
        return $respuesta;
    }

    // LO ALMACENAMOS PARA LUEGO PODER RECORRERLO Y MOSTRARLO POR PANTALLA
    $respuesta["alumnos"]=$sentencia->fetchAll(PDO::FETCH_ASSOC);

    $sentencia=null;
    $conexion=null;
    return $respuesta;    
}

function quitar_nota_alumno_asig($cod_usu, $cod_asig){
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
       
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
        return $respuesta;
    }

    try{
        $consulta="DELETE FROM notas WHERE cod_usu=? AND cod_asig=?";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute([$cod_usu, $cod_asig]);
    }catch(PDOException $e){
        $respuesta["error"]="Imposible realizar la consulta desde QUITAR_NOTA_ALUMNO_ASIG: ".$e->getMessage();
        $sentencia=null;
        $conexion=null;
        return $respuesta; 
    }

    $respuesta["mensaje"]="Asignatura descalificada con éxito";

    $sentencia=null;
    $conexion=null;
    return $respuesta;
}

function cambiar_nota_alumno_asig($cod_usu, $cod_asign, $nota){
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
       
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar con la bd desde cambiar_nota_alumno_asig:".$e->getMessage();
        return $respuesta;
    }
    
    try{
        $consulta="UPDATE notas SET nota=? WHERE cod_usu=? AND cod_asig=?";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute([$nota, $cod_usu, $cod_asig]);
    }catch(PDOException $e){
        $respuesta["error"]="Imposible realizar la consulta desde cambiar_nota_alumno_asig: " .$e->getMessage();
        $sentencia=null;
        $conexion=null;
        return $respuesta;
    }

    $respuesta["mensaje"]="Asignatura cambiada con éxito"    ;
    
    $sentencia=null;
    $conexion=null;
    return $respuesta;
}

function obtener_notas_no_eval_alumno($cod_usu){
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
       
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
        return $respuesta;
    }

    try{
        $consulta="SELECT * FROM asignaturas WHERE cod_asig NOT IN(SELECT cod_asig FROM notas WHERE cod_usu=?)";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute([$cod_usu]);
    }catch(PDOException $e){
        $respuesta["error"]="Imposible realizar la consulta desde obtener_notas_no_eval_alumno:".$e->getMessage();
        $sentencia=null;
        $conexion=null;
        return $respuesta;
    }

    $respuesta["asignaturas"]=$sentencia->fetchAll(PDO::FETCH_ASSOC);

    $sentencia=null;
    $conexion=null;
    return $respuesta;
}


function poner_nota_asig($cod_usu, $cod_asig){
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
       
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
        return $respuesta;
    }

    try{
        $consulta="INSERT INTO notas (cod_usu, cod_asig, nota) VALUES (?,?,0)";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute([$cod_usu, $cod_asig]);
    }catch(PDOException $e){
        $respuesta["error"]="Imposible realizar la consulta desde poner_nota_asig: ".$e->getMessage();
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
