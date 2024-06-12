<?php
session_name("Pract3_Rec_23_24");
session_start();

require "src/funciones_ctes.php";

if(isset($_POST["btnSalir"]))
{
    $datos_env["api_key"]=$_SESSION["api_key"];
    session_destroy();

    consumir_servicios_REST(DIR_SERV."/salir","POST",$datos_env);
    header("Location:index.php");
    exit();
}


if(isset($_SESSION["usuario"]))
{
    
    require "src/seguridad.php";

    if($datos_usuario_log["tipo"]=="normal")
        
        require "vistas/vista_normal.php";
    else
        require "vistas/vista_admin.php";

 
    $conexion=null;
}
elseif(isset($_POST["btnRegistrarse"]) || isset($_POST["btnBorrar"]) || isset($_POST["btnEnviar"])  )
{

    require "vistas/vista_registro.php";
}
else
{
    require "vistas/vista_home.php";
}

?>