<?php
session_name("Examen2_22_23");
session_start();

require "src/func_ctes.php";

if(isset($_POST["btnCalificar"]))
{
    try{
        $conexion=mysqli_connect(SERVIDOR_BD,USUARIO_BD,CLAVE_BD,NOMBRE_BD);
        mysqli_set_charset($conexion,"utf8");
    }
    catch(Exception $e)
    {
        session_destroy();
        die(error_page("Examen2 DWESE 22-23","<h1>Notas de los Alumnos</h1><p>No se ha podido conectar a la BD: ".$e->getMessage()."</p>"));
    }

    try{
        $consulta="insert into notas (cod_asig, cod_alu, nota) values ('".$_POST["asignatura"]."','".$_POST["alumno"]."',0.0)";
        $resultado=mysqli_query($conexion,$consulta);
    }
    catch(Exception $e)
    {
        mysqli_close($conexion);
        session_destroy();
        die(error_page("Examen2 DWESE 22-23","<h1>Notas de los Alumnos</h1><p>No se ha podido realizar la consulta: ".$e->getMessage()."</p>"));
    }

    $_SESSION["mensaje"]="Asignatura calificada con un 0. Cambiala si quieres";
    $_SESSION["alumno"]=$_POST["alumno"];
    $_SESSION["asignatura"]=$_POST["asignatura"];
    header("Location:index.php");
    exit;
}

if(isset($_POST["btnCambiarNota"]))
{
    $error_form=$_POST["nota"]==""||!is_numeric($_POST["nota"]) || $_POST["nota"]<0 ||$_POST["nota"]>10;
    if(!$error_form)
    {
        try{
            $conexion=mysqli_connect(SERVIDOR_BD,USUARIO_BD,CLAVE_BD,NOMBRE_BD);
            mysqli_set_charset($conexion,"utf8");
        }
        catch(Exception $e)
        {
            session_destroy();
            die(error_page("Examen2 DWESE 22-23","<h1>Notas de los Alumnos</h1><p>No se ha podido conectar a la BD: ".$e->getMessage()."</p>"));
        }

        try{
            $consulta="update notas set nota='".$_POST["nota"]."' where cod_asig='".$_POST["btnCambiarNota"]."' and cod_alu='".$_POST["alumno"]."'";
            $resultado=mysqli_query($conexion,$consulta);
        }
        catch(Exception $e)
        {
            mysqli_close($conexion);
            session_destroy();
            die(error_page("Examen2 DWESE 22-23","<h1>Notas de los Alumnos</h1><p>No se ha podido realizar la consulta: ".$e->getMessage()."</p>"));
        }

        $_SESSION["mensaje"]="Nota cambiada con éxito";
        $_SESSION["alumno"]=$_POST["alumno"];
        header("Location:index.php");
        exit;
    }
}

if(isset($_POST["btnBorrarNota"]))
{
    
    try{
        $conexion=mysqli_connect(SERVIDOR_BD,USUARIO_BD,CLAVE_BD,NOMBRE_BD);
        mysqli_set_charset($conexion,"utf8");
    }
    catch(Exception $e)
    {
        session_destroy();
        die(error_page("Examen2 DWESE 22-23","<h1>Notas de los Alumnos</h1><p>No se ha podido conectar a la BD: ".$e->getMessage()."</p>"));
    }

    try{
        $consulta="delete from notas where cod_asig='".$_POST["btnBorrarNota"]."' and cod_alu='".$_POST["alumno"]."'";
        $resultado=mysqli_query($conexion,$consulta);
    }
    catch(Exception $e)
    {
        mysqli_close($conexion);
        session_destroy();
        die(error_page("Examen2 DWESE 22-23","<h1>Notas de los Alumnos</h1><p>No se ha podido realizar la consulta: ".$e->getMessage()."</p>"));
    }

    $_SESSION["mensaje"]="Nota borrado con éxito";
    $_SESSION["alumno"]=$_POST["alumno"];
    header("Location:index.php");
    exit;
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examen2 DWESE 22-23</title>
    <style>
        .error{color:red}
        .mensaje{color:blue;font-size:1.25em}
        table{border-collapse:collapse;text-align:center}
        table,td, th{border:1px solid black}
        th{background-color:#CCC}
        .enlace{border:none;background:none;text-decoration:underline;color:blue;cursor:pointer}
    </style>
</head>
<body>
    <h1>Notas de los Alumnos</h1>
    <?php
    if(!isset($conexion))
    {
        try{
            $conexion=mysqli_connect(SERVIDOR_BD,USUARIO_BD,CLAVE_BD,NOMBRE_BD);
            mysqli_set_charset($conexion,"utf8");
        }
        catch(Exception $e)
        {
            session_destroy();
            die("<p>No se ha podido conectar a la base de batos: ".$e->getMessage()."</p></body></html>");
        }
    }
    try{
        $consulta="select * from alumnos";
        $resultado=mysqli_query($conexion,$consulta);
    }
    catch(Exception $e)
    {
        mysqli_close($conexion);
        session_destroy();
        die("<p>No se ha podido realizar la consulta: ".$e->getMessage()."</p></body></html>");
    }
    
    if(mysqli_num_rows($resultado)>0)
        require "vistas/vista_principal.php";
    else
        echo "<p>En estos momentos no tenemos ningún alumno registrado en la BD</p>";

        
    mysqli_free_result($resultado);
    mysqli_close($conexion);
    ?>
</body>
</html>