<?php
if(isset($_POST["btnInsertar"]))
{
    $url=DIR_SERV."/insertarGrupo";
    //$datos["api_session"]=$_SESSION["api_session"];
    $datos["usuario"]=$_POST["profesor"];
    $datos["dia"]=$_POST["dia"];
    $datos["hora"]=$_POST["hora"];
    $datos["grupo"]=$_POST["grupo"];
    $respuesta=consumir_servicios_REST($url,"POST",$datos);
    $obj=json_decode($respuesta);
    if(!$obj)
    {
        session_destroy();
        die(error_page("Examen 23_24 SW","<h1>Examen 23_24 SW</h1><p>Error consumiendo el servicio: ".$url."</p>"));
    }
    if(isset($obj->error))
    {
        session_destroy();
        die(error_page("Examen 23_24 SW","<h1>Examen 23_24 SW</h1><p>".$obj->error."</p>"));
    }
    if(isset($obj->no_auth))
    {
        session_unset();
        $_SESSION["seguridad"]="El tiempo de sesión de la API ha caducado";
        header("Location:index.php");
        exit;
    }
    $_SESSION["mensaje_accion"]="Grupo insertado correctamente";
    $_SESSION["profesor"]=$_POST["profesor"];
    $_SESSION["dia"]=$_POST["dia"];
    $_SESSION["hora"]=$_POST["hora"];
    header("Location:index.php");
    exit;
}

if(isset($_POST["btnQuitar"]))
{
    $url=DIR_SERV."/borrarGrupo/".$_POST["btnQuitar"];
    //$datos["api_session"]=$_SESSION["api_session"];
    $respuesta=consumir_servicios_REST($url,"DELETE",$datos);
    $obj=json_decode($respuesta);
    if(!$obj)
    {
        session_destroy();
        die(error_page("Examen 23_24 SW","<h1>Examen 23_24 SW</h1><p>Error consumiendo el servicio: ".$url."</p>"));
    }
    if(isset($obj->error))
    {
        session_destroy();
        die(error_page("Examen 23_24 SW","<h1>Examen 23_24 SW</h1><p>".$obj->error."</p>"));
    }
    if(isset($obj->no_auth))
    {
        session_unset();
        $_SESSION["seguridad"]="El tiempo de sesión de la API ha caducado";
        header("Location:index.php");
        exit;
    }
    $_SESSION["mensaje_accion"]="Grupo borrado correctamente";
    $_SESSION["profesor"]=$_POST["profesor"];
    $_SESSION["dia"]=$_POST["dia"];
    $_SESSION["hora"]=$_POST["hora"];
    header("Location:index.php");
    exit;
}


        $url=DIR_SERV."/obtenerUsuarios";
        //$datos["api_session"]=$_SESSION["api_session"];
        $respuesta=consumir_servicios_REST($url,"GET",$datos);
        $obj=json_decode($respuesta);
        if(!$obj)
        {
            session_destroy();
            die(error_page("Examen 23_24 SW","<h1>Examen 23_24 SW</h1><p>Error consumiendo el servicio: ".$url."</p>"));
        }
        if(isset($obj->error))
        {
            session_destroy();
            die(error_page("Examen 23_24 SW","<h1>Examen 23_24 SW</h1><p>".$obj->error."</p>"));
        }
        if(isset($obj->no_auth))
        {
            session_unset();
            $_SESSION["seguridad"]="El tiempo de sesión de la API ha caducado";
            header("Location:index.php");
            exit;
        }

        
        if(isset($_SESSION["profesor"]))
        {
            $_POST["profesor"]=$_SESSION["profesor"];
            $_POST["dia"]=$_SESSION["dia"];
            $_POST["hora"]=$_SESSION["hora"];
        }



        if(isset($_POST["profesor"]))
        {
    
            $url=DIR_SERV."/obtenerHorario/".$_POST["profesor"];
            //$datos["api_session"]=$_SESSION["api_session"];
            $respuesta=consumir_servicios_REST($url,"GET",$datos);
            $obj2=json_decode($respuesta);
            if(!$obj2)
            {
                session_destroy();
                die(error_page("Examen 23_24 SW","<h1>Examen 23_24 SW</h1><p>Error consumiendo el servicio: ".$url."</p>"));
            }
            if(isset($obj2->error))
            {
                session_destroy();
                die(error_page("Examen 23_24 SW","<h1>Examen 23_24 SW</h1><p>".$obj2->error."</p>"));
            }
            if(isset($obj2->no_auth))
            {
                session_unset();
                $_SESSION["seguridad"]="El tiempo de sesión de la API ha caducado";
                header("Location:index.php");
                exit;
            }
        }

        if(isset($_POST["dia"]))
        {
            
            $url=DIR_SERV."/obtenerHorarioDiaHora/".$_POST["profesor"];
            //$datos["api_session"]=$_SESSION["api_session"];
            $datos["dia"]=$_POST["dia"];
            $datos["hora"]=$_POST["hora"];
            $respuesta=consumir_servicios_REST($url,"GET",$datos);
            $obj3=json_decode($respuesta);
            if(!$obj3)
            {
                session_destroy();
                die(error_page("Examen 23_24 SW","<h1>Examen 23_24 SW</h1><p>Error consumiendo el servicio: ".$url."</p>"));
            }
            if(isset($obj3->error))
            {
                session_destroy();
                die(error_page("Examen 23_24 SW","<h1>Examen 23_24 SW</h1><p>".$obj3->error."</p>"));
            }
            if(isset($obj3->no_auth))
            {
                session_unset();
                $_SESSION["seguridad"]="El tiempo de sesión de la API ha caducado";
                header("Location:index.php");
                exit;
            }

            $url=DIR_SERV."/obtenerHorarioNoDiaHora/".$_POST["profesor"];
            //$datos["api_session"]=$_SESSION["api_session"];
            $respuesta=consumir_servicios_REST($url,"GET",$datos);
            $obj4=json_decode($respuesta);
            if(!$obj4)
            {
                session_destroy();
                die(error_page("Examen 23_24 SW","<h1>Examen 23_24 SW</h1><p>Error consumiendo el servicio: ".$url."</p>"));
            }
            if(isset($obj4->error))
            {
                session_destroy();
                die(error_page("Examen 23_24 SW","<h1>Examen 23_24 SW</h1><p>".$obj4->error."</p>"));
            }
            if(isset($obj4->no_auth))
            {
                session_unset();
                $_SESSION["seguridad"]="El tiempo de sesión de la API ha caducado";
                header("Location:index.php");
                exit;
            }

        }
        

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examen 23_24 SW</title>
    <style>
        .enlinea{display:inline}
        .enlace{border:none;background:none;text-decoration:underline;color:blue;cursor:pointer}
        .centro{text-align:center}
        .tabla_hor{width:80%;margin:0 auto; border-collapse:collapse; text-align:center;  }
        .t_dia_hora{border-collapse:collapse; text-align:center; }
        .tabla_hor, th, td, .t_dia_hora{border:1px solid black}
        th{background-color:#CCC}
        .mensaje{font-size:1.25em;color:blue}
    </style>
</head>
<body>
    <h1>Examen 23_24 SW</h1>
    <div>Bienvenido <strong><?php echo $datos_usuario_log->usuario;?></strong> - 
        <form class='enlinea' action="index.php" method="post">
            <button class='enlace' type="submit" name="btnSalir">Salir</button>
        </form>
    </div>
    <h2>Horario de los Profesores</h2>
    <form action='index.php' method='post'>
        <p>
            <label for="profesor">Horario del Profesor:</label>
            <select name="profesor" id="profesor">
                <?php
                foreach($obj->usuarios as $tupla)
                {
                    if($tupla->tipo=="normal")
                    {
                        if(isset($_POST["profesor"]) && $_POST["profesor"]==$tupla->id_usuario)
                        {
                            echo "<option selected value='".$tupla->id_usuario."'>".$tupla->nombre."</option>";
                            $nombre_profesor=$tupla->nombre;
                        }
                        else
                            echo "<option value='".$tupla->id_usuario."'>".$tupla->nombre."</option>";
                    }
                   
                }
                ?>
            </select>
            <button type="submit" name="btnVerHorario">Ver Horario</button>
        </p>
    </form>
    <?php
    if(isset($_POST["profesor"]))
    {

       
        foreach($obj2->horario as $tupla)
        {
            if(isset($horario[$tupla->dia][$tupla->hora]))
                $horario[$tupla->dia][$tupla->hora].="/".$tupla->nombre;
            else
                $horario[$tupla->dia][$tupla->hora]=$tupla->nombre;
        }


        $dias[]="";
        $dias[]="Lunes";
        $dias[]="Martes";
        $dias[]="Miércoles";
        $dias[]="Jueves";
        $dias[]="Viernes";
        $horas[1]="8:15 - 9:15";
        $horas[]="9:15 - 10:15";
        $horas[]="10:15 - 11:15";
        $horas[]="11:15 - 11:45";
        $horas[]="11:45 - 12:45";
        $horas[]="12:45 - 13:45";
        $horas[]="13:45 - 14:45";

        echo "<h3 class='centro'>Horario del Profesor: ".$nombre_profesor."</h3>";
        echo "<table class='tabla_hor'>";
        echo "<tr>";
        for($i=0;$i<=5;$i++)
            echo "<th>".$dias[$i]."</th>";
        echo "</tr>";
        for($hora=1;$hora<=7;$hora++)
        {
            echo "<tr>";
            echo "<th>".$horas[$hora]."</th>";
            if($hora==4)
                echo "<td colspan='5'>RECREO</td>";
            else
            {
                for($dia=1;$dia<=5;$dia++)
                {
                    if(isset($horario[$dia][$hora]))
                    {
                        echo "<td>".$horario[$dia][$hora];
                        echo "<form action='index.php' method='post'>";
                        echo "<input type='hidden' name='profesor' value='".$_POST["profesor"]."'><input type='hidden' name='dia' value='".$dia."'><input type='hidden' name='hora' value='".$hora."'>";
                        echo "<button class='enlace' name='btnEditar'>Editar</button>";
                        echo "</form></td>";
                    }
                    else
                    {
                        echo "<td>";
                        echo "<form action='index.php' method='post'>";
                        echo "<input type='hidden' name='profesor' value='".$_POST["profesor"]."'><input type='hidden' name='dia' value='".$dia."'><input type='hidden' name='hora' value='".$hora."'>";
                        echo "<button class='enlace' name='btnEditar'>Editar</button>";
                        echo "</form></td>";
                    }

                }
            }
            echo "</tr>";
        }
        echo "</table>";

        if(isset($_POST["dia"]))
        {
            if($_POST["hora"]<=3)
                echo "<h2>Editando la ".$_POST["hora"]."º hora (".$horas[$_POST["hora"]].") del ".$dias[$_POST["dia"]]."</h2>";
            else
                echo "<h2>Editando la ".($_POST["hora"]-1)."º hora (".$horas[$_POST["hora"]].") del ".$dias[$_POST["dia"]]."</h2>";


            if(isset($_SESSION["mensaje_accion"]))
            {
                echo "<p class='mensaje'>".$_SESSION["mensaje_accion"]."</p>";
                unset($_SESSION["mensaje_accion"]);
                unset($_SESSION["profesor"]);
                unset($_SESSION["dia"]);
                unset($_SESSION["hora"]);

            }

            echo "<table class='t_dia_hora'>";
            echo "<tr><th>Grupo</th><th>Acción</th></tr>";
            foreach($obj3->horario as $tupla)
            {
                echo "<tr>";
                echo "<td>".$tupla->nombre."</td>";
                echo "<td>";
                echo "<form action='index.php' method='post'>";
                echo "<input type='hidden' name='profesor' value='".$_POST["profesor"]."'><input type='hidden' name='dia' value='".$_POST["dia"]."'><input type='hidden' name='hora' value='".$_POST["hora"]."'>";
                echo "<button class='enlace' name='btnQuitar' value='".$tupla->id_horario."'>Quitar</button>";
                echo "</form></td>";
                echo "</tr>";
            }
            echo "</table>";
            
            ?>
            <form action="index.php" method="post">
                <p>
                <?php
                    echo "<input type='hidden' name='profesor' value='".$_POST["profesor"]."'>
                        <input type='hidden' name='dia' value='".$_POST["dia"]."'>
                        <input type='hidden' name='hora' value='".$_POST["hora"]."'>";
                    echo '<select name="grupo">';
                        foreach($obj4->horario as $tupla)
                        {
                            echo "<option value='".$tupla->id_grupo."'>".$tupla->nombre."</option>";
                        }
                    ?>
                    </select>
                    <button type="submit" name="btnInsertar">Añadir</button>
                </p>
            </form>

            <?php
        }
    }
    ?>
</body>
</html>