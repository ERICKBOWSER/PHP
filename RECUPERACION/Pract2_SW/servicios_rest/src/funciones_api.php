<?php

require 'src/conf_bd.php';

function insertar_usuario($datos){
    try{
        $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'")); 
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar a la BD. Erro: " .$e->getMessage();
        return $respuesta;
    }

    try{
        $consulta='insert into usuarios(nombre,usuario,clave,dni,sexo,subscripcion) values(?,?,?,?,?,?)';
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute($datos[]);
        $respuesta['ultm_id']=$conexion->lastInsertId();
        $sentencia=null;
        $conexion=null;
        return $respuesta;

    }
    catch(PDOException $e){
        $sentencia=null;
        $conexion=null;
        $respuesta["error"]="Error en la consulta. Erro: " .$e->getMessage();
        return $respuesta;
    }
}

function actualizar_foto($datos){
    try{
        $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'")); 
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar a la BD. Erro: " .$e->getMessage();
        return $respuesta;
    }

    try{
        $consulta='update usuarios set foto=? WHERE id_usuario=?';
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute([$datos]);
        $respuesta['mensaje']="Actualización realizada con éxito";
        $sentencia=null;
        $conexion=null;
        return $respuesta;

    }
    catch(PDOException $e){
        $sentencia=null;
        $conexion=null;
        $respuesta["error"]="Error en la consulta. Erro: " .$e->getMessage();
        return $respuesta;
    }
}

function repetido_insertando($tabla, $columna, $valor){
    try{
        $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'")); 
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar a la BD. Erro: " .$e->getMessage();
        return $respuesta;
    }

    try{
        $consulta='SELECT * FROM ' . $tabla . " WHERE " . $columna . "=?";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute([$valor]);
        $respuesta['repetido']=$sentencia->rowCount()>0; // Tiene que devolver true o false, para eso comprobamos si la sentencia tiene datos
        $sentencia=null;
        $conexion=null;
        return $respuesta;

    }
    catch(PDOException $e){
        $sentencia=null;
        $conexion=null;
        $respuesta["error"]="Error en la consulta. Erro: " .$e->getMessage();
        return $respuesta;
    }
}

function repetido_editando($tabla, $columna, $valor, $columna_clave, $valor_clave){
    try{
        $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'")); 
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar a la BD. Erro: " .$e->getMessage();
        return $respuesta;
    }

    try{
        $consulta="SELECT " . $columna . " FROM " . $tabla . " WHERE " . $columna . "=? AND " . $columna_clave . " " . $valor_clave;
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute([$valor, $valor_clave]);
        $respuesta['repetido']=$sentencia->rowCount()>0; // Tiene que devolver true o false, para eso comprobamos si la sentencia tiene datos
        $sentencia=null;
        $conexion=null;
        return $respuesta;

    }
    catch(PDOException $e){
        $sentencia=null;
        $conexion=null;
        $respuesta["error"]="Error en la consulta. Erro: " .$e->getMessage();
        return $respuesta;
    }
}

function obtener_todos_usuarios(){
    try{
        $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'")); 
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar a la BD. Erro: " .$e->getMessage();
        return $respuesta;
    }

    try{
        $consulta='SELECT * FROM usuarios WHERE tipo <> "admin"';
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute();
        $respuesta['usuarios']=$sentencia->fetchAll(PDO::FETCH_ASSOC);
        $sentencia=null;
        $conexion=null;
        return $respuesta;

    }
    catch(PDOException $e){
        $sentencia=null;
        $conexion=null;
        $respuesta["error"]="Error en la consulta. Erro: " .$e->getMessage();
        return $respuesta;
    }
}

function obtener_usuarios_pag($pagina, $registros){
    try{
        $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'")); 
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar a la BD. Erro: " .$e->getMessage();
        return $respuesta;
    }

    try{
        $consulta='SELECT * FROM usuarios WHERE tipo <> "admin" LIMIT ' . $pagina . "," . $registros;
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute();
        $respuesta['usuarios']=$sentencia->fetchAll(PDO::FETCH_ASSOC);
        $sentencia=null;
        $conexion=null;
        return $respuesta;

    }
    catch(PDOException $e){
        $sentencia=null;
        $conexion=null;
        $respuesta["error"]="Error en la consulta. Erro: " .$e->getMessage();
        return $respuesta;
    }
}

function obtener_todos_usuarios_filtro($buscar){
    try{
        $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'")); 
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar a la BD. Erro: " .$e->getMessage();
        return $respuesta;
    }

    try{
        $consulta="SELECT * FROM usuarios WHERE tipo <> 'admin' AND nombre LIKE '%" . $buscar . "%'";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute();
        $respuesta['usuarios']=$sentencia->fetchAll(PDO::FETCH_ASSOC);
        $sentencia=null;
        $conexion=null;
        return $respuesta;

    }
    catch(PDOException $e){
        $sentencia=null;
        $conexion=null;
        $respuesta["error"]="Error en la consulta. Erro: " .$e->getMessage();
        return $respuesta;
    }
}

function obtener_detalles_usuario($id_usuario){
    try{
        $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'")); 
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar a la BD. Erro: " .$e->getMessage();
        return $respuesta;
    }

    try{
        $consulta="SELECT * FROM usuarios WHERE id_usuario=?";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute();
        $respuesta['usuario']=$sentencia->fetch(PDO::FETCH_ASSOC);
        $sentencia=null;
        $conexion=null;
        return $respuesta;

    }
    catch(PDOException $e){
        $sentencia=null;
        $conexion=null;
        $respuesta["error"]="Error en la consulta. Erro: " .$e->getMessage();
        return $respuesta;
    }
}

function borrar_usuario($id_usuario){
    try{
        $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'")); 
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar a la BD. Erro: " .$e->getMessage();
        return $respuesta;
    }

    try{
        $consulta="DELETE FROM usuarios WHERE id_usuario=?";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute([$id_usuario]);
        $respuesta['mensaje']="Usuario borrado con exito";
        $sentencia=null;
        $conexion=null;
        return $respuesta;

    }
    catch(PDOException $e){
        $sentencia=null;
        $conexion=null;
        $respuesta["error"]="Error en la consulta. Erro: " .$e->getMessage();
        return $respuesta;
    }
}

function actualizar_usuario_clave($datos){
    try{
        $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'")); 
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar a la BD. Erro: " .$e->getMessage();
        return $respuesta;
    }

    try{
        $consulta="UPDATE usuarios SET nombre=?, usuario=?, dni=?, sexo=?, subscripcion=?";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute($datos[]);
        $respuesta['mensaje']="Usuario editado con éxito";
        $sentencia=null;
        $conexion=null;
        return $respuesta;

    }
    catch(PDOException $e){
        $sentencia=null;
        $conexion=null;
        $respuesta["error"]="Error en la consulta. Erro: " .$e->getMessage();
        return $respuesta;
    }
}


function actualizar_usuario_sin_clave($datos){
    try{
        $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'")); 
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar a la BD. Erro: " .$e->getMessage();
        return $respuesta;
    }

    try{
        $consulta="UPDATE usuarios SET nombre=?, usuario=?, dni=?, sexo=?, subscripcion=?";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute($datos[]);
        $respuesta['mensaje']="Usuario editado con éxito";
        $sentencia=null;
        $conexion=null;
        return $respuesta;

    }
    catch(PDOException $e){
        $sentencia=null;
        $conexion=null;
        $respuesta["error"]="Error en la consulta. Erro: " .$e->getMessage();
        return $respuesta;
    }
}

function login($datos){
    try{
        $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'")); 
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar a la BD. Erro: " .$e->getMessage();
        return $respuesta;
    }

    try{
        $consulta="SELECT * FROM usuarios WHERE usuario=? AND clave=?";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute($datos[]);
        if($sentencia->rowCount()){
            session_name("api_pract2");
            session_start();

            $respuesta['usuario'] = $sentencia->fetch(PDO::FETCH_ASSOC);
            $respuesta['api_key']= session_id();

            $session['usuario']=$respuesta['usuario']['usuario'];
            $session['clave']=$respuesta['usuario']['clave'];
            $session['tipo']=$respuesta['usuario']['tipo'];

            
        }else{
            $respuesta['mensaje']="El usuario no se encuentra registrado en la BD";
        }
        $sentencia=null;
        $conexion=null;
        return $respuesta;

    }
    catch(PDOException $e){
        $sentencia=null;
        $conexion=null;
        $respuesta["error"]="Error en la consulta. Erro: " .$e->getMessage();
        return $respuesta;
    }
}

function logueado($datos){
    try{
        $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'")); 
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar a la BD. Erro: " .$e->getMessage();
        return $respuesta;
    }

    try{
        $consulta="SELECT * FROM usuarios WHERE usuario=? AND clave=?";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute($datos[]);
        if($sentencia->rowCount()){
            $respuesta['usuario'] = $sentencia->fetch(PDO::FETCH_ASSOC);            
        }else{
            $respuesta['mensaje']="El usuario no se encuentra registrado en la BD";
        }
        $sentencia=null;
        $conexion=null;
        return $respuesta;

    }
    catch(PDOException $e){
        $sentencia=null;
        $conexion=null;
        $respuesta["error"]="Error en la consulta. Erro: " .$e->getMessage();
        return $respuesta;
    }
}

?>