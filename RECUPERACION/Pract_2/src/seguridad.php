<?php
try{
    $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'")); 
}
catch(PDOException $e){
    session_destroy();
    die(error_page("Práctica Rec 2","<h1>Práctica Rec 2</h1><p>Imposible conectar a la BD. Error:".$e->getMessage()."</p>"));
}

try{
    $datos[0]=$_SESSION["usuario"];
    $datos[1]=$_SESSION["clave"];
    $consulta = "SELECT * FROM usuarios WHERE usuario=? AND clave=?";
    $sentencia=$conexion->prepare($consulta);
    $sentencia->execute($datos);
}
catch(PDOException $e){
    $sentencia=null;
    $conexion=null;
    session_destroy();
    die(error_page("Práctica Rec 2","<h1>Práctica Rec 2</h1><p>Imposible realizar la consulta. Error:".$e->getMessage()."</p>"));
}

if($sentencia->rowCount()<=0)
{
        $sentencia=null;
        $conexion=null;
        session_unset();
        $_SESSION["seguridad"]="Usted ya no se encuentra registrado en la BD";
        header("Location:index.php");
        exit();
}
// Acabo de pasar el control de baneo
$datos_usuario_log=$sentencia->fetch(PDO::FETCH_ASSOC);
$sentencia=null;

//Ahora paso el control de tiempo

if(time()-$_SESSION["ultm_accion"]>MINUTOS*60)
{
    $conexion=null;
    session_unset();
    $_SESSION["seguridad"]="Su tiempo de sesión ha expirado. Por favor vuelva a loguearse";
    header("Location:index.php");
    exit();
}
// Paso el control de tiempo y lo renuevo
$_SESSION["ultm_accion"]=time();
?>