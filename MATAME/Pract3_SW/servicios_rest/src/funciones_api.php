<?php

require "src/conf_bd.php";

function login($datos){
    try{
        $conexion = new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    }catch(PDOException $e){
        $respuesta["error_bd"]="Imposible conectar a la BD desde LOGIN. Error: ".$e->getMessage();
        return $respuesta;
    }

    try{
        $consulta="SELECT * FROM usuarios WHERE usuario=? AND clave=?";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute($datos);

        if($sentencia->rowCount()>0){
            session_name("API_pract3");
            session_start();

            $respuesta["usuario"]=$sentencia->fetch(PDO::FETCH_ASSOC);
            $respuesta["api_key"]=session_id();

            $_SESSION["usuario"]=$respuesta["usuario"]["usuario"];
            $_SESSION["clave"]=$respuesta["usuario"]["clave"]
            $_SESSION["tipo"]=$respuesta["usuario"]["tipo"];

        }else{
            $respuesta["mensaje"]="El usuario no se encuentra registrado en la BD desde LOGIN";
        }

        $sentencia=null;
        $conexion=null;
        return $respuesta;
    }catch(PDOException $e){
        $sentencia=null;
        $conexion=null;
        $respuesta["error_bd"]="Error en la consulta desde LOGIN: ".$e->getMessage();
        return $respuesta;
    }
}

function logueado($datos){
    try{
        $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'")); 
    }
    catch(PDOException $e){
        $respuesta["error_bd"]="Imposible conectar a la BD desde LOGUEADO. Error:".$e->getMessage();
        return $respuesta;
    }
    
    try{
        $consulta="SELECT * FROM usuarios WHERE usuario=? AND clave=?";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute($datos);

        if($sentencia->rowCount()>0){
            $respuesta["usuario"]=$sentencia->fetch(PDO::FETCH_ASSOC);
        }else{
            $respuesta["mensaje"]="El usuario no se encuentra registrado en la BD desde LOGUEADO"
        }

        $conexion=null;
        $sentencia=null;
        return $respuesta;

    }catch(PDOException $e){
        $sentencia=null;
        $conexion=null;
        $respuesta["error_bd"]="Error en la consulta desde LOGUEADO. Error: ".$e->getMessage();
        return $respuesta;
    }
}

function insertar_usuario($datos){
    try{
        $conexion new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND=> "SET NAMES 'utf8'"));
    }catch(PDOException $e){
        $respuesta["error_bd"]="Imposible conectar a la BD desde INSERTAR_USUARIO. Error: ".$e->getMessage();
        return $respuesta;
    }

    try{
        $consulta="INSERT INTO usuarios(nombre, usuario, clave, dni, sexo, subscripcion) VALUES (?,?,?,?,?,?)";
        $sentencia=$conexion-prepare($consulta);
        $sentencia->execute($datos);
        $respuesta["ultm_id"]=$conexion->lastInsertId(); // DEVUELVE EL ID DE LA ÚLTIMA INSERCIÓN, SIEMPRE Y CUANDO EL ID SEA AUTOINCREMENT
        $sentencia=null;
        $conexion=null;
        return $respuesta;
    }catch(PDOException $e){
        $sentencia=null;
        $conexion=null;
        $respuesta["error_bd"]="Error en la consulta desde INSERTAR_USUARIO. Error: ".$e->getMessage();
        return $respuesta;
    }
}

function actualizar_foto($datos){
    try{
        $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
    }catch(PDOException $e){
        $respuesta["error_bd"]="Imposible conectar a la BD desde ACTUALIZAR FOTO. Error: ".$e->getMessage();
        return $respuesta;
    }

    try{
        $consulta="UPDATE usuarios SET foto=? WHERE id_usuario=?";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute($datos);
        $respuesta["mensaje"]="Actualización realizada con éxito desde ACTUALIZAR_FOTO.";
        $sentencia=null;
        $conexion=null;
        return $respuesta;
    }catch(PDOException $e){
        $sentencia=null;
        $conexion=null;
        $respuesta["error_bd"]="Error en la consulta desde ACTUALIZAR_FOTO. Error: ".$e->getMessage();
        return $respuesta;
    }
}

function repetido_insertando($tabla, $columna, $valor){
    try{
        $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
    }catch(PDOException $e){
        $respuesta["error_bd"]="Imposible conectar a la BD desde REPETIDO_INSERTANDO. Error: ".$e->getMessage();
        return $respuesta;
    }

    try{
        $consulta="SELECT ".$columna. " FROM ".$tabla." WHERE ".$columna."=?";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute([$valor]);
        $respuesta["repetido"]=$sentencia->rowCount()>0;
        $sentencia=null;
        $conexion=null;
        return $respuesta;
    }catch(PDOException $e){
        $sentencia=null;
        $conexion=null;
        $respuesta["error_bd"]="Error en la consulta desde REPETIDO_INSERTANDO. Error: ".$e->getMessage();
        return $respuesta;
    }
}

function repetido_editando($tabla, $columna, $valor, $columna_clave, $valor_clave){
    try{
        $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
    }catch(PDOException $e){
        $respuesta["error_bd"]="Imposible conectar a la BD desde repetido_editando. Error; ".$e->getMessage();
        return $respuesta;
    }

    try{
        $consulta="SELECT ".$columna." FROM ".$tabla." WHERE ".$columna."=? AND ".$columna_clave."<>?";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute([$valor, $valor_clave]);
        $respuesta["repetido"]=$sentencia->rowCount()>0;
        $sentencia=null;
        $conexion=null;
        return $respuesta;
    }catch(PDOException $e){
        $sentencia=null;
        $conexion=null;
        $respuesta["error_bd"]="Error en la consulta desde REPETIDO_EDITANDO. Error: ".$e->getMessage();
        return $respuesta;
    }
}

function obtener_todos_usuarios(){
    try{
        $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'")); 
    }
    catch(PDOException $e){
        $respuesta["error_bd"]="Imposible conectar a la BD desde OBTENER_TODOS_USUARIOS. Error:".$e->getMessage();
        return $respuesta;
    }

    try{
        $consulta="SELECT * FROM usuarios WHERE tipo<>'admin'";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute();
        $respuesta["usuarios"]=$sentencia->fetchAll(PDO::FETCH_ASSOC);
        $sentencia=null;
        $conexion=null;
        return $respuesta;        
    }catch(PDOException $e){
        $sentencia=null;
        $conexion=null;
        $respuesta["error_bd"]="Error en la consulta desde OBTENER_TODOS_USUARIOS. Error: ".$e->getMessage();
        return $respuesta;
    }
}

function obtener_usuarios_pag($pagina, $registros){
    try{
        $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'")); 
    }
    catch(PDOException $e){
        $respuesta["error_bd"]="Imposible conectar a la BD. Error:".$e->getMessage();
        return $respuesta;
    }

    try{
        $consulta="SELECT * FROM usuarios WHERE tipo<>'admin' LIMIT ".$pagina.",".$registros;
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute();
        $respuesta["usuarios"]=$sentencia->fetchAll(PDO::FECTH_ASSOC);
        $sentencia=null;
        $conexion=null;
        return $respuesta;
    }catch(PDOException $e){
        $sentencia=null;
        $conexion=null;
        $respuesta["error_bd"]="Error en la consulta OBTENER_USUARIOS_PAG. Error: ".$e->getMessage();
        return $respuesta;
    }
}

function obtener_todos_usuarios_filtro($buscar){
    try{
        $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'")); 
    }
    catch(PDOException $e){
        $respuesta["error_bd"]="Imposible conectar a la BD desde OBTENER_TODOS_USUARIOS_FILTRO. Error:".$e->getMessage();
        return $respuesta;
    }

    try{
        $consulta="SELECT * FROM usuarios WHERE tipo<>'admin' AND nombre LIKE '%".$buscar."%'";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute();
        $respuesta["usuarios"]=$sentencia->fetchAll(PDO::FETCH_ASSOC);
        $sentencia=null;
        $conexion=null;
        return $respuesta;
    }catch(PDOException $e){
        $sentencia=null;
        $conexion=null;
        $respuesta["error_bd"]="Error en la consulta OBTENER_TODOS_USUARIOS_FILTRO. Error: ".$e->getMessage();
        return $respuesta;
    }
}

function obtener_usuarios_filtro_pag($pagina, $registros, $buscar){
    try{
        $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'")); 
    }
    catch(PDOException $e){
        $respuesta["error_bd"]="Imposible conectar a la BD DESDE OBTENER_USUARIOS_FILTRO_PAG. Error:".$e->getMessage();
        return $respuesta;
    }

    try{
        $consulta="SELECT * FROM usuarios WHERE tipo<>'admin' AND nombre LIKE '%".$buscar."%' LIMIT ".$pagina.",".$registros;
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute();
        $respuesta["usuarios"]=$sentencia->fetchAll(PDO::FETCH_ASSOC);
        $sentencia=null;
        $conexion=null;
        return $respuesta;
    }catch(PDOException $e){
        $sentencia=null;
        $conexion=null;
        $respuesta["error_bd"]="Error en la consulta desde OBTENER_USUARIOS_FILTRO_PAG. Error: ".$e->getMessage();
        return $respuesta;
    }
}

function obtener_detalles_usuario($id_usuario){
    try{
        $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'")); 
    }
    catch(PDOException $e){
        $respuesta["error_bd"]="Imposible conectar a la BD. Error:".$e->getMessage();
        return $respuesta;
    }

    try{
        $consulta="SELECT * FROM usuarios WHERE id_usuario=?";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute([$id_usuario]);
        $respuesta["usuario"]=$sentencia->fetch(PDO::FETCH_ASSOC); // DEVUELVE FALSE SI NO TIENE
        return $respuesta;
    }catch(PDOException $e){
        $sentencia=null;
        $conexion=null;
        $respuesta["error_bd"]="Error en la consulta OBTENER_TODOS_USUARIOS_FILTRO. Error: ".$e->getMessage();
        return $respuesta;
    }
}

function borrar_usuario($id_usuario){
    try{
        $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'")); 
    }
    catch(PDOException $e){
        $respuesta["error_bd"]="Imposible conectar a la BD. Error:".$e->getMessage();
        return $respuesta;
    }
    try{
        $consulta="DELETE FROM usuarios WHERE id_usuario=?";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute([$id_usuario]);
        $respuesta["mensaje"]="Usuario borrado con éxito";
        $sentencia=null;
        $conexion=null;
        return $respuesta;
    }catch(PDOException $e){
        $sentencia=null;
        $conexion=null;
        $respuesta["error_bd"]="Error en la consulta desde BORRAR_USUARIO: Error: ".$e->getMessage();
        return $respuesta;
    }
}

function actualizar_usuario_clave($datos){
    try{
        $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'")); 
    }
    catch(PDOException $e){
        $respuesta["error_bd"]="Imposible conectar a la BD. Error:".$e->getMessage();
        return $respuesta;
    }

    try{
        $consulta="UPDATE usuarios SET nombre=?, usuario=?, clave=?, dni=?, sexo=?, subscripcion=? WHERE id_usuario=?";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute($datos);
        $respuesta["mensaje"]="Usuario editando con éxito";
        $sentencia=null;
        $conexion=null;
        return $respuesta;
    }catch(PDOException $e){
        $sentencia=null;
        $conexion=null;
        $respuesta["error_bd"]="Error en la consulta. Error:".$e->getMessage();
        return $respuesta;
    }
}

function actualizar_usuario_sin_clave($datos){
    try{
        $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'")); 
    }
    catch(PDOException $e){
        $respuesta["error_bd"]="Imposible conectar a la BD. Error:".$e->getMessage();
        return $respuesta;
    }

    try{
        $consulta="UPDATE usuarios SET nombre=?, usuario=', dni=?, sexo=?, subscripcion=? WHERE id_usuario=?";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute($datos);
        $respuesta["mensaje"]="usuario editado con éxito.";
        $sentencia=null;
        $conexion=null;
        return $respuesta;
    }catch(PDOException $e){
        $sentencia=null;
        $conexion=null;
        $respuesta["error_bd"]="Error en la consulta desde ACTUALIZAR_USUARIO_SIN_CLAVE. Error: ".$e->getMessage();
        return $respuesta;
    }
}

