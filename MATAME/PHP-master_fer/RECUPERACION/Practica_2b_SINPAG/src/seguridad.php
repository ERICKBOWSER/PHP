<?php

try{
    $consulta="select * from usuarios where lector='".$_SESSION["usuario"]."' and clave='".$_SESSION["clave"]."'";
    $resultado=mysqli_query($conexion, $consulta);
 }
 catch(Exception $e)
 {
     session_destroy();
     mysqli_close($conexion);
     die(error_page("Examen3 Curso 23-24","<h1>Librería</h1><p>No se ha podido realizar la consulta: ".$e->getMessage()."</p>"));
 }

if(mysqli_num_rows($resultado)<=0)
{
    mysqli_free_result($resultado);
    mysqli_close($conexion);
    session_unset();
    $_SESSION["seguridad"]="Usted ya no se encuentra registrado en la BD";
    header("Location:".$salto);
    exit;
}

$datos_usuario_logueado=mysqli_fetch_assoc($resultado);
mysqli_free_result($resultado);

// Ahora control de inactividad

if(time()-$_SESSION["ultima_accion"]>MINUTOS_INACT*60)
{
    mysqli_close($conexion);
    session_unset();
    $_SESSION["seguridad"]="Su tiempo de sesión ha caducado";
    header("Location:".$salto);
    exit;
}

$_SESSION["ultima_accion"]=time();

?>