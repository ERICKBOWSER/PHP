
<?php

require "src/conf_bd.php";



function login($datos)
{

    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible conectar a la BD. Error:" . $e->getMessage();
        return $respuesta;
    }


    try {
        $consulta = "select * from usuarios where usuario=? AND clave=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute($datos);
        if($sentencia->rowCount()>0){
            session_name("API_Pract2_Rec_23_24");
            session_start();

            $respuesta["usuario"]=$sentencia->fetch(PDO::FETCH_ASSOC);
            $respuesta["api_key"]=session_id();

            $_SESSION["usuario"]=$respuesta["usuario"];
            $_SESSION["clave"]=$respuesta["clave"];
            $_SESSION["tipo"]=$respuesta["tipo"];


        }else{
            $respuesta["mensaje"] = "El usuario no se encuentra registrado en la BD";
        }
       
        $sentencia = null;
        $conexion = null;
        return $respuesta;
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        $respuesta["error"] = "Error en la consulta. Error:" . $e->getMessage();
        return $respuesta;
    }
}







function logueado($datos)
{

    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible conectar a la BD. Error:" . $e->getMessage();
        return $respuesta;
    }


    try {
        $consulta = "select * from usuarios where usuario=? AND clave=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute($datos);

        if($sentencia->rowCount()>0){

            $respuesta["usuario"]=$sentencia->fetch(PDO::FETCH_ASSOC);

        }else{
            $respuesta["mensaje"] = "El usuario no se encuentra registrado en la BD";
        }
       
        $sentencia = null;
        $conexion = null;
        return $respuesta;
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        $respuesta["error"] = "Error en la consulta. Error:" . $e->getMessage();
        return $respuesta;
    }
}















function insertar_usuario($datos)
{

    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible conectar a la BD. Error:" . $e->getMessage();
        return $respuesta;
    }


    try {
        $consulta = "insert into usuarios(nombre,usuario,clave,dni,sexo,subscripcion) values(?,?,?,?,?,?)";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute($datos);
        $respuesta["ultm_id"] = $conexion->lastInsertId();
        $sentencia = null;
        $conexion = null;
        return $respuesta;
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        $respuesta["error"] = "Error en la consulta. Error:" . $e->getMessage();
        return $respuesta;
    }
}


function actualizar_foto($datos)
{

    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible conectar a la BD. Error:" . $e->getMessage();
        return $respuesta;
    }


    try {
        $consulta = "update usuarios set foto=? where id_usuario=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute($datos);
        $respuesta["mensaje"] = "Actualizacion realizada con exito";
        $sentencia = null;
        $conexion = null;
        return $respuesta;
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        $respuesta["error"] = "Error en la consulta. Error:" . $e->getMessage();
        return $respuesta;
    }
}


function repetido_insertando($tabla,$columna,$valor)
{

    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible conectar a la BD. Error:" . $e->getMessage();
        return $respuesta;
    }


    try {
        $consulta = "select ".$columna." from ".$tabla." where ".$columna."=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute($valor);
        $respuesta["repetido"] = $sentencia->rowCount()>0;
        $sentencia = null;
        $conexion = null;
        return $respuesta;
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        $respuesta["error"] = "Error en la consulta. Error:" . $e->getMessage();
        return $respuesta;
    }
}


function repetido_editando($tabla,$columna,$valor,$columna_clave,$valor_clave)
{

    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible conectar a la BD. Error:" . $e->getMessage();
        return $respuesta;
    }


    try {
        $consulta = "select ".$columna." from ".$tabla." where ".$columna."=? AND ".$columna_clave."<>?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute($valor,$valor_clave);
        $respuesta["repetido"] = $sentencia->rowCount()>0;
        $sentencia = null;
        $conexion = null;
        return $respuesta;
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        $respuesta["error"] = "Error en la consulta. Error:" . $e->getMessage();
        return $respuesta;
    }
}


function obtener_todos_usuarios()
{

    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible conectar a la BD. Error:" . $e->getMessage();
        return $respuesta;
    }


    try {
        $consulta = "select * from usuarios where  tipo<>'admin'";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute();
        $respuesta["usuarios"]= $sentencia->fetchAll(PDO::FETCH_ASSOC);
        $sentencia = null;
        $conexion = null;
        return $respuesta;
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        $respuesta["error"] = "Error en la consulta. Error:" . $e->getMessage();
        return $respuesta;
    }
}




function obtener_todos_usuarios_pag($pagina,$registros)
{

    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible conectar a la BD. Error:" . $e->getMessage();
        return $respuesta;
    }


    try {
        $consulta = "select * from usuarios where  tipo<>'admin' LIMIT ".$pagina.",".$registros;
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute();
        $respuesta["usuarios"]= $sentencia->fetchAll(PDO::FETCH_ASSOC);
        $sentencia = null;
        $conexion = null;
        return $respuesta;
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        $respuesta["error"] = "Error en la consulta. Error:" . $e->getMessage();
        return $respuesta;
    }
}





function obtener_todos_usuarios_filtro($buscar)
{

    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible conectar a la BD. Error:" . $e->getMessage();
        return $respuesta;
    }


    try {
        $consulta = "select * from usuarios where  tipo<>'admin' and nombre LIKE '%".$buscar."%'";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute();
        $respuesta["usuarios"]= $sentencia->fetchAll(PDO::FETCH_ASSOC);
        $sentencia = null;
        $conexion = null;
        return $respuesta;
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        $respuesta["error"] = "Error en la consulta. Error:" . $e->getMessage();
        return $respuesta;
    }
}


//REVISAR ESTE NO ME DIO TIEMPO A COPIAR

function obtener_todos_usuarios_filtro_pag($pagina,$registros,$buscar)
{

    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible conectar a la BD. Error:" . $e->getMessage();
        return $respuesta;
    }


    try {
        $consulta = "select * from usuarios where  tipo<>'admin' and nombre LIKE '%".$buscar."%'";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute();
        $respuesta["usuarios"]= $sentencia->fetchAll(PDO::FETCH_ASSOC);
        $sentencia = null;
        $conexion = null;
        return $respuesta;
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        $respuesta["error"] = "Error en la consulta. Error:" . $e->getMessage();
        return $respuesta;
    }
}





function obtener_detalles_usuario($id_usuario)
{

    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible conectar a la BD. Error:" . $e->getMessage();
        return $respuesta;
    }


    try {
        $consulta = "select * from usuarios where id_usuario=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$id_usuario]);
        $respuesta["usuarios"]= $sentencia->fetchAll(PDO::FETCH_ASSOC);
        $sentencia = null;
        $conexion = null;
        return $respuesta;
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        $respuesta["error"] = "Error en la consulta. Error:" . $e->getMessage();
        return $respuesta;
    }
}


function borrar_usuario($id_usuario)
{

    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible conectar a la BD. Error:" . $e->getMessage();
        return $respuesta;
    }


    try {
        $consulta = "delete from usuarios where id_usuario=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$id_usuario]);
        $respuesta["mensaje"]="Usuario borrado con exito";
        $sentencia = null;
        $conexion = null;
        return $respuesta;
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        $respuesta["error"] = "Error en la consulta. Error:" . $e->getMessage();
        return $respuesta;
    }
}


function actualizar_usuario_clave($datos)
{

    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible conectar a la BD. Error:" . $e->getMessage();
        return $respuesta;
    }


    try {
        $consulta = "update usuarios set nombre=?,usuario=?,clave=?,dni=?,sexo=?,subscripcion=? where id_usuario=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute($datos);
        $respuesta["ultm_id"] = "Usuario editado con exito";
        $sentencia = null;
        $conexion = null;
        return $respuesta;
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        $respuesta["error"] = "Error en la consulta. Error:" . $e->getMessage();
        return $respuesta;
    }
}



function actualizar_usuario_sin_clave($datos)
{

    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible conectar a la BD. Error:" . $e->getMessage();
        return $respuesta;
    }


    try {
        $consulta = "update usuarios set nombre=?,usuario=?,dni=?,sexo=?,subscripcion=? where id_usuario=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute($datos);
        $respuesta["ultm_id"] = "Usuario editado con exito";
        $sentencia = null;
        $conexion = null;
        return $respuesta;
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        $respuesta["error"] = "Error en la consulta. Error:" . $e->getMessage();
        return $respuesta;
    }
}


?>