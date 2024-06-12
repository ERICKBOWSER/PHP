<?php

if(isset($_POST["btnBorrar"]))
{
    
    $url=DIR_SERV."/quitarNota/".$_POST["alumno"];
    $datos["cod_asig"]=$_POST["asignatura"];
    $respuesta=consumir_servicios_REST($url,"DELETE",$datos);
    $obj=json_decode($respuesta);
    if(!$obj)
    {
        session_destroy();
        die(error_page("Examen4 DWESE Curso 23-24","<h1>Notas de los alumnos</h1><p>Error consumiendo el servicio: ".$url."</p>"));
    }

    if(isset($obj->error))
    {
        session_destroy();
        die(error_page("Examen4 DWESE Curso 23-24","<h1>Notas de los alumnos</h1><p>".$obj->error."</p>"));
    }

    $_SESSION["alumno"]=$_POST["alumno"];
    $_SESSION["mensaje_accion"]="¡¡ Nota descalificada con éxito !!";
    header("Location:index.php");
    exit;
    
}


if(isset($_POST["btnCambiar"]))
{
    $error_nota=$_POST["nota"]=="" || !is_numeric($_POST["nota"]) || $_POST["nota"]<0 || $_POST["nota"]>10;
    if(!$error_nota)
    {
        $url=DIR_SERV."/cambiarNota/".$_POST["alumno"];
        $datos["cod_asig"]=$_POST["asignatura"];
        $datos["nota"]=$_POST["nota"];
        $respuesta=consumir_servicios_REST($url,"PUT",$datos);
        $obj=json_decode($respuesta);
        if(!$obj)
        {
            session_destroy();
            die(error_page("Examen4 DWESE Curso 23-24","<h1>Notas de los alumnos</h1><p>Error consumiendo el servicio: ".$url."</p>"));
        }

        if(isset($obj->error))
        {
            session_destroy();
            die(error_page("Examen4 DWESE Curso 23-24","<h1>Notas de los alumnos</h1><p>".$obj->error."</p>"));
        }

        $_SESSION["alumno"]=$_POST["alumno"];
        $_SESSION["mensaje_accion"]="¡¡ Nota cambiada con éxito !!";
        header("Location:index.php");
        exit;
    }
}

if(isset($_POST["btnCalificar"]))
{
   
    $url=DIR_SERV."/ponerNota/".$_POST["alumno"];
    $datos["cod_asig"]=$_POST["cod_asig"];
    $respuesta=consumir_servicios_REST($url,"POST",$datos);
    $obj=json_decode($respuesta);
    if(!$obj)
    {
        session_destroy();
        die(error_page("Examen4 DWESE Curso 23-24","<h1>Notas de los alumnos</h1><p>Error consumiendo el servicio: ".$url."</p>"));
    }

    if(isset($obj->error))
    {
        session_destroy();
        die(error_page("Examen4 DWESE Curso 23-24","<h1>Notas de los alumnos</h1><p>".$obj->error."</p>"));
    }

    $_SESSION["alumno"]=$_POST["alumno"];
    $_SESSION["cod_asig"]=$_POST["cod_asig"];
    $_SESSION["mensaje_accion"]="¡¡ Asignatura calificada con un 0. Cambie la nota si lo estima necesario !!";
    header("Location:index.php");
    exit;
    
}


if(isset($_SESSION["alumno"]))
    $_POST["alumno"]=$_SESSION["alumno"];

if(isset($_SESSION["cod_asig"]))
{
    $_POST["asignatura"]=$_SESSION["cod_asig"];
    $_POST["btnEditar"]=true;
}
  

$url=DIR_SERV."/alumnos";
$respuesta=consumir_servicios_REST($url,"GET",$datos);
$obj=json_decode($respuesta);
if(!$obj)
{
    session_destroy();
    die(error_page("Examen4 DWESE Curso 23-24","<h1>Notas de los alumnos</h1><p>Error consumiendo el servicio: ".$url."</p>"));
}

if(isset($obj->error))
{
    session_destroy();
    die(error_page("Examen4 DWESE Curso 23-24","<h1>Notas de los alumnos</h1><p>".$obj->error."</p>"));
}

if(isset($_POST["alumno"] ))
{
    $url=DIR_SERV."/notasAlumno/".$_POST["alumno"];
    $respuesta=consumir_servicios_REST($url,"GET",$datos);
    $obj2=json_decode($respuesta);
    if(!$obj2)
    {
        session_destroy();
        die(error_page("Examen4 DWESE Curso 23-24","<h1>Notas de los alumnos</h1><p>Error consumiendo el servicio: ".$url."</p>"));
    }

    if(isset($obj2->error))
    {
        session_destroy();
        die(error_page("Examen4 DWESE Curso 23-24","<h1>Notas de los alumnos</h1><p>".$obj2->error."</p>"));
    }

    $url=DIR_SERV."/NotasNoEvalAlumno/".$_POST["alumno"];
    $respuesta=consumir_servicios_REST($url,"GET",$datos);
    $obj3=json_decode($respuesta);
    if(!$obj3)
    {
        session_destroy();
        die(error_page("Examen4 DWESE Curso 23-24","<h1>Notas de los alumnos</h1><p>Error consumiendo el servicio: ".$url."</p>"));
    }

    if(isset($obj3->error))
    {
        session_destroy();
        die(error_page("Examen4 DWESE Curso 23-24","<h1>Notas de los alumnos</h1><p>".$obj3->error."</p>"));
    }


}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examen4 DWESE Curso 23-24</title>
    <style>
        .enlinea{display:inline}
        .enlace{background:none;border:none;text-decoration:underline;color:blue;cursor:pointer}
        table, th, td{border:1px solid black}
        table{border-collapse:collapse; text-align:center}
        th{background-color:#CCC}
        .error{color:red}
        .mensaje{font-size:1.25em;color:blue}
    </style>
</head>
<body>
    <h1>Notas de los alumnos</h1>
    <div>
        Bienvenido <strong><?php echo $datos_usuario_log->usuario;?></strong> - <form class='enlinea' action="../index.php" method="post"><button name="btnSalir" type="submit" class='enlace'>Salir</form> 
    </div>
    <?php
    if(count($obj->alumnos)<=0)
    {
        echo "<p>En estos momentos no tenemos ningún alumno registrado en la BD.</p>";
    }
    else
    {
    ?>
        <form action="index.php" method="post">
            <p>
                <label for="alumno">Seleccione un alumno: </label>
                <select name="alumno" id="alumno">
                    <?php
                    foreach($obj->alumnos as $tupla)
                    {
                        if(isset($_POST["alumno"]) && $_POST["alumno"]==$tupla->cod_usu)
                        {
                            echo "<option selected value='".$tupla->cod_usu."'>".$tupla->nombre."</option>";
                            $nombre_alumno=$tupla->nombre;
                        }
                        else
                            echo "<option value='".$tupla->cod_usu."'>".$tupla->nombre."</option>";
                    }

                    ?>
                </select>
                <button type="submit" name="btnVerNotas">Ver Notas</button>
            </p>
        </form>
    <?php
        if(isset($_POST["alumno"]))
        {
            echo "<h2>Notas del alumno ".$nombre_alumno."</h2>";
        
            echo "<table>";
            echo "<tr><th>Asignatura</th><th>Nota</th><th>Acción</th></tr>";
            
                foreach ($obj2->notas as $tupla) {
                    echo "<tr>";
                    echo "<td>".$tupla->denominacion."</td>";
                    if((isset($_POST["btnEditar"]) && $_POST["asignatura"]==$tupla->cod_asig) || (isset($_POST["btnCambiar"]) && $_POST["asignatura"]==$tupla->cod_asig))
                    {
                        if(isset($_POST["btnEditar"]))
                            $nota=$tupla->nota;
                        else
                            $nota=$_POST["nota"];

                        echo "<td>";
                        echo "<form action='index.php' method='post'>";
                        echo "<input type='text' placeholder='Introduzca un número entre 0 y 10 ' name='nota' value='".$nota."'>";
                        if(isset($_POST["btnCambiar"]))
                            echo "<br><span class='error'>* No has introducido un valor válido de nota *</span>";
                        
                        echo "</td>";
                        echo "<td>";
                        echo "<input type='hidden' name='alumno' value='".$_POST["alumno"]."'><input type='hidden' name='asignatura' value='".$tupla->cod_asig."'>";
                        echo "<button type='submit' class='enlace' name='btnCambiar'>Cambiar</button> - <button type='submit' class='enlace' name='btnAtras'>Atrás</button></form>";
                        echo "</td>";
                    }
                    else{
                        echo "<td>".$tupla->nota."</td>";
                        echo "<td>";
                        echo "<form action='index.php' method='post'>";
                        echo "<input type='hidden' name='alumno' value='".$_POST["alumno"]."'><input type='hidden' name='asignatura' value='".$tupla->cod_asig."'>";
                        echo "<button type='submit' class='enlace' name='btnEditar'>Editar</button> - <button type='submit' class='enlace' name='btnBorrar'>Borrar</button>";
                        echo "</form>";
                        echo "</td>";
                    }
                    

                    echo "</tr>";
                }
        
            echo "</table>";
            
            if(isset($_SESSION["mensaje_accion"]))
            {
                    echo "<p class='mensaje'>".$_SESSION["mensaje_accion"]."</p>";
                    unset($_SESSION["mensaje_accion"]);
                    unset($_SESSION["alumno"]);
                    if(isset($_SESSION["cod_asig"]))
                        unset($_SESSION["cod_asig"]);
                    
            }    

            if(count($obj3->notas)>0)
            {
            ?>
                <form action="index.php" method="post">
                    <input type="hidden" name="alumno" value="<?php echo $_POST["alumno"];?>">
                    <p>
                        <label for="cod_asig">Asignaturas que a <strong><?php echo $nombre_alumno;?></strong> aún le quedan por calificar.</label>
                        <select id="cod_asig" name="cod_asig">
                        <?php
                            foreach($obj3->notas as $tupla)
                            {
                                echo "<option value='".$tupla->cod_asig."'>".$tupla->denominacion."</option>";
                            }
                        ?>
                        </select>
                        <button type="submit" name="btnCalificar">Calificar</button>
                    </p>
                </form>

            <?php
            }
            else
            {
                echo "<p>A  <strong>".$nombre_alumno."</strong> no le quedan asignaturas por calificar.</p>";
            }
        }
    }
    ?>
</body>
</html>