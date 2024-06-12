<?php

if(isset($_POST["btnInsertar"])){
    $url=DIR_SERV."/insertarGrupo";
    $datos["usuario"]=$_POST["profesor"]; // EL PROFESOR SELECCIONADO DEL QUE ESTAMOS ENSEÑANDO LA TABLA
    $datos["dia"]=$_POST["dia"];
    $datos["hora"]=$_POST["hora"];
    $datos["grupo"]=$_POST["grupo"];

    $respuesta=consumir_servicios_REST($url, "POST", $datos);
    $jsonInsert=json_decode($respuesta, true);
    if(!$jsonInsert){
        session_destroy();
        die(error_page("Examen2_SW", "<h1>Horario de los profesores</h1><p>Error consumiendo el servicio btnInsertar. URL: ".$url."</p>"));
    }

    if(isset($jsonInsert["error"])){
        session_destroy();
        die(error_page("Examen2_SW", "<h1>Horario de los profesores</h1><p>".$jsonInsert["error"]."</p>"));
    }

    if(isset($jsonInsert["no_auth"])){
        session_unset();
        $_SESSION["seguridad"]="Usted ha dejado de tener acceso a la API. Por favor loguearse.";
        header("Location:index.php");
        exit();
    }

    // SI HA PASADO TODO ESTO
    $_SESSION["mensaje_acccion"]="Grupo insertado correctamente";
    $_SESSION["profesor"]=$_POST["profesor"];
    $_SESSION["dia"]=$_POST["dia"];
    $_SESSION["hora"]=$_POST["hora"];
    header("Location:index.php");
    exit;
}

if(isset($_POST["btnQuitar"])){
    $url=DIR_SERV."/borrarGrupo/".$_POST["btnQuitar"];
    $respuesta=consumir_servicios_REST($url, "DELETE", $datos_env);
    $jsonBorrar=json_decode($respuesta, true);
    if(!$jsonBorrar)
    {
        session_destroy();
        die(error_page("Examen 23_24 SW","<h1>Examen 23_24 SW</h1><p>Error consumiendo el servicio: ".$url."</p>"));
    }
    if(isset($jsonBorrar["error"]))
    {
        session_destroy();
        die(error_page("Examen 23_24 SW","<h1>Examen 23_24 SW</h1><p>".$obj->error."</p>"));
    }
    if(isset($jsonBorrar["no_auth"]))
    {
        session_unset();
        $_SESSION["seguridad"]="El tiempo de sesión de la API ha caducado";
        header("Location:index.php");
        exit;
    }

    $_SESSION["mensaje_accion"]="Grupo borrado correctamente.";
    $_SESSION["profesor"]=$_POST["profesor"];
    $_SESSION["dia"]=$_POST["dia"];
    $_SESSION["hora"]=$_POST["hora"];
    header("Location:index.php");
    exit;
}



$respuesta=consumir_servicios_REST(DIR_SERV."/obtenerProfesores","GET", $datos_env); // COMO ESTO SE EJECUTA EN index.php NO HACE FALTA HACER OTRO REQUIRE PARA TRAER LOS DATOS DE seguridad.php
$json=json_decode($respuesta, true);
if(!$json){
    session_destroy();
    die(error_page("Examen2_SW", "<h1>Horario de los profesores</h1><p>Error consumiendo el servicio obtenerProfesores</p>"));
}

if(isset($json["error"])){
    session_destroy();
    die(error_page("Examen2_SW", "<h1>Horario de los profesores</h1><p>".$json["error"]."</p>"));
}

if(isset($json["no_auth"])){
    session_unset(); // ES unset() YA QUE QUEREMOS QUE SE MUESTRE EL SIGUIENTE $_SESSION
    $_SESSION["seguridad"]="Usted ha dejado de tener acceso a la API. Por favor vuelva a loguearse.";
    header("Location: index.php");
    exit();

}

$profesores=$json["profesores"]; // OBTENEMOS EL DATO DE LA FUNCIÓN obtener_profesores() QUE ESTA EN funciones_servicios.php

if(isset($_SESSION["profesor"])){
    $_POST["profesor"]=$_SESSION["profesor"];
    $_POST["dia"]=$_SESSION["dia"];
    $_POST["hora"]=$_SESSION["hora"];
}

if(isset($_POST["profesor"])){
    $respuesta=consumir_servicios_REST(DIR_SERV."/obtenerHorario/".$_POST["profesor"], "GET", $datos_env);
    $json2=json_decode($respuesta, true);
    if(!$json2){
        session_destroy();
        die(error_page("Examen2_SW","<h1>Horario de los profesores</h1><p>Error consumiendo el servicio obtenerHorario</p>"));
    }

    if(isset($json2["error"])){
        session_destroy();
        die(error_page("Examen2_SW", "<h1>Horario de los profesores</h1><p>".$json2["error"]."</p>"));
    }

    if(isset($json2["no_auth"])){
        session_unset();
        $_SESSION["seguridad"]="Usted ha dejado de tener acceso a la API. Por favor vuelva a loguearse.";
        header("Location: index.php");
        exit();
    }

    $horarioProfesor=$json2["horario"];
}

if(isset($_POST["dia"])){
    $url=DIR_SERV."/obtenerHorarioDiaHora/".$_POST["profesor"];
    $datos["dia"]=$_POST["dia"];
    $datos["hora"]=$_POST["hora"];
    $respuesta=consumir_servicios_REST($url, "GET", $datos);
    $json3=json_decode($respuesta, true);

    if(!$json3){
        session_destroy();
        die(error_page("Examen2_SW", "<h1>Horario de los profesores</h1><p>Error consumiendo el servicio: ".$url."</p>"));
    }

    if(isset($json3["error"])){
        session_destroy();
        die(error_page("Examen2_SW","<h1>Horario de los profesores</h1><p>".$json3["error"]."</p>"));
    }
    if(isset($json3["no_auth"])){
        session_unset();
        $_SESSION["seguridad"]="Usted ha dejado de tener acceso a la API. Por favor vuelva a loguearse.";
        header("Location: index.php");
        exit();
    }

    $horarioDiaHora=$json3["horario"]; // LE PASAMOS LOS DATOS DE LA FUNCION 

    $url= DIR_SERV."/obtenerHorarioNoDiaHora/".$_POST["profesor"];
    $respuesta2=consumir_servicios_REST($url, "GET", $datos);
    $json4=json_decode($respuesta2, true);
    if(!$json4){
        session_destroy();
        die(error_page("Examen2_SW", "<h1>Horario de los profesores</h1><p>Error consumiendo el servicio desde json4: ".$url."</p>"));
    }
    if(isset($json4["error"])){
        session_destroy();
        die(error_page("Examen2_SW", "<h1>Horario de los profesores</h1><p>".$json4["error"]."</p>"));
    }

    if(isset($json4["no_auth"])){
        session_unset();
        $_SESSION["seguridad"]="El tiempo de sesión de la API ha caducado.";
        header("Location:index.php");
        exit();
    }

    $horarioNoDiaHora=$json4["horario"];

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examen 2</title>
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
    <h1>Examen2 PHP</h1>

    <div>
        Bienvenido <strong><?php echo $datos_usuario_log["usuario"];?></strong> -
        <form class="en_linea" action="index.php" method="post">
            <button class="enlace" name="btnSalir" type="submit">Salir</button>
        </form>
    </div>
    <h2>Horario de los Profesores</h2>
    <?php
    if(count($profesores)>0){
        ?>
        <form action="index.php" method="post">
            <label for="profesor">Horario del Profesor: </label>
            <select id="profesor" name="profesor">
                <?php 
                foreach ($profesores as $tupla) {
                    if(isset($_POST["profesor"]) && $_POST["profesor"]==$tupla["id_usuario"]){
                        echo "<option selected value='".$tupla["id_usuario"]."'>".$tupla["nombre"]."</option>";
                        $nombre_profesor=$tupla["nombre"];
                    }else{
                        echo "<option value='".$tupla["id_usuario"]."'>".$tupla["nombre"]."</option>";
                    }
                    

                }
                ?>
            </select>
            <button type="submit" name="btnVerHorario">Ver Horario</button>
        </form>
        <?php
    }else{
        echo "<p>Actualmente no hay usuarios en la BBDD.</p>";
    }

    if(isset($_POST["profesor"])){
        echo "<h2>Horario del Profesor: ".$nombre_profesor."</h2>";

        foreach ($horarioProfesor as $tupla) {
            if(isset($horarioProfesor[$tupla["dia"]][$tupla["hora"]])){
               $horarioProfesor[$tupla["dia"]][$tupla["hora"]].="/".$tupla["nombre"];
            }else{
                $horarioProfesor[$tupla["dia"]][$tupla["hora"]]=$tupla["nombre"];
            }
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

        echo "<table class='tabla_hor'>";
        echo "<tr>";
        // CREAMOS LAS 6 COLUMNAS EN LA 1ra FILA
        for($i=0;$i<=5;$i++){
            echo "<th>".$dias[$i]."</th>";
        }
        echo "</tr>";
        // COLOCAMOS LAS HORAS EN ORDEN
        for($hora=1;$hora<=7;$hora++){
            echo "<tr>";
            echo "<th>".$horas[$hora]."</th>";
            if($hora == 4){
                echo "<td colspan='5'>RECREO</td>";
            }else{
                for($dia=1;$dia<=5;$dia++){
                    if(isset($horarioProfesor[$dia][$hora])){
                        echo "<td>".$horarioProfesor[$dia][$hora];
                        echo "<form action='index.php' method='post'>";
                        echo "<input type='hidden' name='profesor' value='".$_POST["profesor"]."'>
                            <input type='hidden' name='dia' value='".$dia."'>
                            <input type='hidden' name='hora' value='".$hora."'>";
                            // LOS INPUT DE ARRIBA LOS USAMOS LUEGO PARA PASARLE LOS DATOS DE DIA Y HORA PARA EDITAR Y BORRAR
                        echo "<button class='enlace' name='btnEditar'>Editar</button>";
                        echo "</form></td>";
                    }else{
                        echo "<td>";
                        echo "<form action='index.php' method='post'>";
                        echo "<input type='hidden' name='profesor' value='".$_POST["profesor"]."'>
                            <input type='hidden' name='dia' value='".$dia."'>
                            <input type='hidden' name='hora' value='".$hora."'>";
                        echo "<button class='enlace' name='btnEditar'>Editar</button>";
                        echo "</form></td>";
                    }
                }
            }
            echo "</tr>";
        }
        echo "</table>";

        // EDITAR Y BORRAR
        if(isset($_POST["dia"])){
            if($_POST["hora"]<=3){
                echo "<h2>Editando la ".$_POST["hora"]."º hora (".$horas[$_POST["hora"]].") del ".$dias[$_POST["dia"]]."</h2>";
            }else{
                echo "<h2>Editando la ".($_POST["hora"]-1)."º hora (".$horas[$_POST["hora"]].") del "  .$dias[$_POST["dia"]]."</h2>";
            }

            if(isset($_SESSION["mensaje_accion"])){
                echo "<p class='mensaje'>".$_SESSION["mensaje_accion"]."</p>";
                unset($_SESSION["mensaje_accion"]);
                unset($_SESSION["profesor"]);
                unset($_SESSION["dia"]);
                unset($_SESSION["hora"]);
            }

            echo "<table class='t_dia_hora'>";
            echo "<tr><th>Grupo</th><th>Acción</th></tr>";
            foreach($horarioDiaHora as $tupla){
                echo "<tr>";
                echo "<td>".$tupla["nombre"]."</td>";
                echo "<td>";
                echo "<form action='index.php' method='post'>";
                echo "<input type='hidden' name='profesor' value='".$_POST["profesor"]."'>
                    <input type='hidden' name='dia' value='".$_POST["dia"]."'>
                    <input type='hidden' name='hora' value='".$_POST["hora"]."'>";
                echo "<button type='submit' class='enlace' name='btnQuitar' value='".$tupla["id_horario"]."'>Quitar</button>";
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
                    echo "<select name='grupo'>";
                        foreach($horarioNoDiaHora as $tupla){
                            echo "<option value='".$tupla["id_grupo"]."'>".$tupla["nombre"]."</option>";
                        }
                    ?>
                    </select>
                    <button type="submit" name="btnInsertar">Añadir</button>
                </p>
            </form>
            <?php
        }              
        //var_dump($horarioProfesor);

    }else{
        echo "ALGO FALLA";
    }

    ?>
</body>
</html>