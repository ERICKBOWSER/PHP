<?php
if(isset($_POST["btnBorrarNota"]))
{

    $datos_env["cod_asig"]=$_POST["cod_asig"];
    $respuesta=consumir_servicios_REST(DIR_SERV."/quitarNota/".$_POST["alumnos"],"DELETE",$datos_env);
    $json=json_decode($respuesta,true);
    if(!$json)
    {
        session_destroy();
        die(error_page("Examen4 DWESE Curso 23-24","<h1>Notas de los alumnos</h1><p>Sin respuesta oportuna de la API</p>"));  
    }

    if(isset($json["error"]))
    {
        session_destroy();
        consumir_servicios_REST(DIR_SERV."/salir","POST",$datos_env);
        die(error_page("Examen4 DWESE Curso 23-24","<h1>Notas de los alumnos</h1><p>".$json["error"]."</p>"));
    }

    if(isset($json["no_auth"]))
    {
        session_unset();
        $_SESSION["seguridad"]="Usted ha dejado de tener acceso a la API. Por favor vuelva a loguearse.";
        header("Location:index.php");
        exit();
    }


    $_SESSION["mensaje_accion"]="¡¡ Asignatura descalificada con Éxito !!";
    $_SESSION["alumnos"]=$_POST["alumnos"];
    header("Location:index.php");
    exit;
}

if(isset($_POST["btnCalificar"]))
{

    $datos_env["cod_asig"]=$_POST["asignaturas"];
    $respuesta=consumir_servicios_REST(DIR_SERV."/ponerNota/".$_POST["alumnos"],"POST",$datos_env);
    $json=json_decode($respuesta,true);
    if(!$json)
    {
        session_destroy();
        die(error_page("Examen4 DWESE Curso 23-24","<h1>Notas de los alumnos</h1><p>Sin respuesta oportuna de la API</p>"));  
    }

    if(isset($json["error"]))
    {
        session_destroy();
        consumir_servicios_REST(DIR_SERV."/salir","POST",$datos_env);
        die(error_page("Examen4 DWESE Curso 23-24","<h1>Notas de los alumnos</h1><p>".$json["error"]."</p>"));
    }

    if(isset($json["no_auth"]))
    {
        session_unset();
        $_SESSION["seguridad"]="Usted ha dejado de tener acceso a la API. Por favor vuelva a loguearse.";
        header("Location:index.php");
        exit();
    }


    $_SESSION["mensaje_accion"]="¡¡ Asignatura calificada con un 0. Cambie la nota si lo estima necesario !!";
    $_SESSION["alumnos"]=$_POST["alumnos"];
    $_SESSION["calificado"]=$_POST["asignaturas"];
    header("Location:index.php");
    exit;
}

if(isset($_SESSION["alumnos"]))
{
    $_POST["alumnos"]=$_SESSION["alumnos"];
    unset($_SESSION["alumnos"]);
}

if(isset($_SESSION["calificado"]))
{
    $_POST["btnEditarNota"]=true;
    $_POST["cod_asig"]=$_SESSION["calificado"];
    unset($_SESSION["calificado"]);
}

if(isset($_POST["alumnos"]))
{
    $respuesta=consumir_servicios_REST(DIR_SERV."/notasAlumno/".$_POST["alumnos"],"GET",$datos_env);
    $json=json_decode($respuesta,true);
    if(!$json)
    {
        session_destroy();
        die(error_page("Examen4 DWESE Curso 23-24","<h1>Notas de los alumnos</h1><p>Sin respuesta oportuna de la API</p>"));  
    }

    if(isset($json["error"]))
    {
        session_destroy();
        consumir_servicios_REST(DIR_SERV."/salir","POST",$datos_env);
        die(error_page("Examen4 DWESE Curso 23-24","<h1>Notas de los alumnos</h1><p>".$json["error"]."</p>"));
    }

    if(isset($json["no_auth"]))
    {
        session_unset();
        $_SESSION["seguridad"]="Usted ha dejado de tener acceso a la API. Por favor vuelva a loguearse.";
        header("Location:index.php");
        exit();
    }
    $notas_alumno=$json["notas"];

    $respuesta=consumir_servicios_REST(DIR_SERV."/notasNoEvalAlumno/".$_POST["alumnos"],"GET",$datos_env);
    $json=json_decode($respuesta,true);
    if(!$json)
    {
        session_destroy();
        die(error_page("Examen4 DWESE Curso 23-24","<h1>Notas de los alumnos</h1><p>Sin respuesta oportuna de la API</p>"));  
    }

    if(isset($json["error"]))
    {
        session_destroy();
        consumir_servicios_REST(DIR_SERV."/salir","POST",$datos_env);
        die(error_page("Examen4 DWESE Curso 23-24","<h1>Notas de los alumnos</h1><p>".$json["error"]."</p>"));
    }

    if(isset($json["no_auth"]))
    {
        session_unset();
        $_SESSION["seguridad"]="Usted ha dejado de tener acceso a la API. Por favor vuelva a loguearse.";
        header("Location:index.php");
        exit();
    }

    $asig_no_eval=$json["asignaturas"];

}

if(isset($_POST["btnCambiarNota"]))
{
    $error_form=$_POST["nota"]==""||!is_numeric($_POST["nota"]) || $_POST["nota"]<0 || $_POST["nota"]>10;
    if(!$error_form)
    {
        

        $datos_env["cod_asig"]=$_POST["cod_asig"];
        $datos_env["nota"]=$_POST["nota"];
        $respuesta=consumir_servicios_REST(DIR_SERV."/cambiarNota/".$_POST["alumnos"],"PUT",$datos_env);
        $json=json_decode($respuesta,true);
        if(!$json)
        {
            session_destroy();
            die(error_page("Examen4 DWESE Curso 23-24","<h1>Notas de los alumnos</h1><p>Sin respuesta oportuna de la API</p>"));  
        }

        if(isset($json["error"]))
        {
            session_destroy();
            consumir_servicios_REST(DIR_SERV."/salir","POST",$datos_env);
            die(error_page("Examen4 DWESE Curso 23-24","<h1>Notas de los alumnos</h1><p>".$json["error"]."</p>"));
        }

        if(isset($json["no_auth"]))
        {
            session_unset();
            $_SESSION["seguridad"]="Usted ha dejado de tener acceso a la API. Por favor vuelva a loguearse.";
            header("Location:index.php");
            exit();
        }


        $_SESSION["mensaje_accion"]="¡¡ Nota cambiada con Éxito !!";
        $_SESSION["alumnos"]=$_POST["alumnos"];
        header("Location:index.php");
        exit;

    }
}

//Este código se ejecuta siempre al poner la vista

$respuesta=consumir_servicios_REST(DIR_SERV."/alumnos","GET",$datos_env);
$json=json_decode($respuesta,true);
if(!$json)
{
    session_destroy();
    die(error_page("Examen4 DWESE Curso 23-24","<h1>Notas de los alumnos</h1><p>Sin respuesta oportuna de la API</p>"));  
}

if(isset($json["error"]))
{
    session_destroy();
    consumir_servicios_REST(DIR_SERV."/salir","POST",$datos_env);
    die(error_page("Examen4 DWESE Curso 23-24","<h1>Notas de los alumnos</h1><p>".$json["error"]."</p>"));
}

if(isset($json["no_auth"]))
{
    session_unset();
    $_SESSION["seguridad"]="Usted ha dejado de tener acceso a la API. Por favor vuelva a loguearse.";
    header("Location:index.php");
    exit();
}

$alumnos=$json["alumnos"];

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examen4 DWESE Curso 23-24</title>
    <style>
        .en_linea{display:inline}
        .enlace{border:none;background:none;color:blue;text-decoration:underline;cursor:pointer}
        .mensaje{font-size:1.25em;color:blue}
        table,th, td{border:1px solid black;}
        table{border-collapse:collapse;text-align:center}
        th{background-color:#CCC}
        .error{color:red}
    </style>
</head>
<body>
    <h1>Notas de los alumnos</h1>
    <div>
        Bienvenido <strong><?php echo $datos_usuario_log["usuario"];?></strong> - 
        <form class="en_linea" action="../index.php" method="post">
            <button class="enlace" name="btnSalir" type="submit">Salir</button>
        </form>
    </div>
   <?php
    if(count($alumnos)<=0)
        echo "<p>En estos momentos no tenemos registrado ningún alumno en la BD</p>";
    else
    {
    ?>
        <form action="index.php" method="post">
            <p>
                <label for="alumnos">Seleccione un alumno: </label>
                <select name="alumnos" id="alumnos">
                <?php
                    foreach($alumnos as $tupla)
                    {
                        if(isset($_POST["alumnos"]) && $_POST["alumnos"]==$tupla["cod_usu"])
                        {
                            echo "<option selected value='".$tupla["cod_usu"]."'>".$tupla["nombre"]."</option>";
                            $nombre_alumno=$tupla["nombre"];
                        }
                        else
                            echo "<option value='".$tupla["cod_usu"]."'>".$tupla["nombre"]."</option>";
                    }
                ?>
                </select>
                <button type="submit" name="btnVerNotas">Ver Notas</button>
            </p>
        </form>
    <?php
        if(isset($_POST["alumnos"]))
        {
            echo "<h2>Notas del alumno ".$nombre_alumno."</h2>";

            echo "<table>";
            echo "<tr><th>Asignatura</th><th>Nota</th><th>Acción</th></tr>";
            foreach($notas_alumno as $tupla)
            {
                echo "<tr>";
                echo "<td>".$tupla["denominacion"]."</td>";
                echo "<td><form action='index.php' method='post'>";
                echo "<input type='hidden' name='alumnos' value='".$_POST["alumnos"]."'/>";
                echo "<input type='hidden' name='cod_asig' value='".$tupla["cod_asig"]."'/>";
                if((isset($_POST["btnEditarNota"])||  isset($_POST["btnCambiarNota"]))&& $_POST["cod_asig"]==$tupla["cod_asig"])
                {
                    if(isset($_POST["btnEditarNota"]))
                        echo "<input type='text' name='nota' value='".$tupla["nota"]."'/>";
                    else
                    {
                        echo "<input type='text' name='nota' value='".$_POST["nota"]."'/>";
                        echo "<br/><span class='error'>No has introducido un valor válido de Nota</span>";
                    }
                    echo "</td>";
                    echo "<td>";
                    echo"<button class='enlace' type='submit' name='btnCambiarNota'>Cambiar</button> - <button type='submit'  class='enlace'>Atrás</button>";
                }
                else
                {
                    echo $tupla["nota"]."</td>";
                    echo "<td>";
                    echo"<button class='enlace' type='submit' name='btnEditarNota'>Editar</button> - <button type='submit' name='btnBorrarNota' class='enlace'>Borrar</button>";
                }
                echo "</form>";
                echo "</td>";
                echo "</tr>";
            }
            echo "</table>";
            if(isset($_SESSION ["mensaje_accion"]))
            {
                echo "<p class='mensaje'>".$_SESSION ["mensaje_accion"]."</p>";
                unset($_SESSION["mensaje_accion"]);
            }


            if(count($asig_no_eval)>0)
            {
            ?>
                <form action="index.php" method="post">
                    <p>
                        <input type="hidden" value="<?php echo $_POST["alumnos"];?>" name="alumnos"/>
                        <label for="asignaturas">Asignaturas que a <strong><?php echo $nombre_alumno;?></strong> aún le quedan por calificar:</label>
                        <select id="asignaturas" name="asignaturas">
                        <?php
                        foreach($asig_no_eval as $tupla)
                            echo "<option value='".$tupla["cod_asig"]."'>".$tupla["denominacion"]."</option>";
                        ?>
                        </select>
                        <button type="submit" name="btnCalificar">Calificar</button>
                    </p>
                </form>
            <?php
            }
            else
                echo "<p>A <strong>".$nombre_alumno."</strong> no le quedan asignaturas por calificar</p>";
        }
    }
   ?>
</body>
</html>