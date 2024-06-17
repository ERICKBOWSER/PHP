<?php

if(isset($_POST["btnQuitar"])){
    $respuesta=consumir_servicios_REST(DIR_SERV."/borrarGrupo/".$_POST["btnQuitar"], "DELETE", $datos_env);
    $json=json_decode($respuesta, true);
    if(!$json){
        session_destroy();
        die(error_page("Examen2 PHP con SW","<h1>Examen2 PHP con SW</h1><p>Sin respuesta oportuna de la API desde vista_exmamen:btnQuitar</p>"));
    }
    
    if(isset($json["error"])){
        session_destroy();
        consumir_servicios_REST(DIR_SERV."/salir", "POST", $datos_env);
        die(error_page("Examen2 PHP con SW","<h1>Examen2 PHP con SW</h1><p>".$json["error"]."</p>"));  
    }
    
    if(isset($json["no_auth"])){
        session_unset();
        $_SESSION["seguridad"]="Usted ha dejado de tener acceso a la API. Por favor vuelva a loguearse";
        header("Location:index.php");
        exit();
    }

    $_SESSION["mensaje_accion"]="Grupo quitado con éxito";
    $_SESSION["profesores"]=$_POST["profesores"];
    $_SESSION["dia"]=$_POST["dia"];
    $_SESSION["hora"]=$_POST["hora"];

    header("Location:index.php");
    exit();

}

if(isset($_POST["btnAgregar"])){
    $respuesta=consumir_servicios_REST(DIR_SERV."/agregarGrupo/".$_POST["dia"]."/".$_POST["hora"]."/".$_POST["profesores"]."/".$_POST["grupo"], "POST", $datos_env);
    $json=json_decode($respuesta, true);
    if(!$json){
        session_destroy();
        die(error_page("Examen2 PHP con SW","<h1>Examen2 PHP con SW</h1><p>Sin respuesta oportuna de la API desde vista_exmamen:btnQuitar</p>"));
    }
    
    if(isset($json["error"])){
        session_destroy();
        consumir_servicios_REST(DIR_SERV."/salir", "POST", $datos_env);
        die(error_page("Examen2 PHP con SW","<h1>Examen2 PHP con SW</h1><p>".$json["error"]."</p>"));  
    }
    
    if(isset($json["no_auth"])){
        session_unset();
        $_SESSION["seguridad"]="Usted ha dejado de tener acceso a la API. Por favor vuelva a loguearse";
        header("Location:index.php");
        exit();
    }

    $_SESSION["mensaje_accion"]="Grupo quitado con éxito";
    $_SESSION["profesores"]=$_POST["profesores"];
    $_SESSION["dia"]=$_POST["dia"];
    $_SESSION["hora"]=$_POST["hora"];

    header("Location:index.php");
    exit();

}


//  ESTO TIENE QUE SER ANTES DE $_POST["PROFESORES"] PORQUE SINO NO FUNCIONA
if(isset($_SESSION["mensaje_accion"])){
    $_POST["profesores"]=$_SESSION["profesores"];
    $_POST["dia"]=$_SESSION["dia"];
    $_POST["hora"]=$_SESSION["hora"];
    // PARA QUE DEJEN DE FUNCIONAR
    unset($_SESSION["profesores"]);
    unset($_SESSION["dia"]);
    unset($_SESSION["hora"]);
}


if(isset($_POST["profesores"])){
    $respuesta=consumir_servicios_REST(DIR_SERV."/obtenerHorario/".$_POST["profesores"], "GET", $datos_env);
    $json=json_decode($respuesta, true);
    if(!$json){
        session_destroy();
        die(error_page("Examen2 PHP con SW","<h1>Examen2 PHP con SW</h1><p>Sin respuesta oportuna de la API desde vista_exmamen:profesores</p>"));
    }
    
    if(isset($json["error"])){
        session_destroy();
        consumir_servicios_REST(DIR_SERV."/salir", "POST", $datos_env);
        die(error_page("Examen2 PHP con SW","<h1>Examen2 PHP con SW</h1><p>".$json["error"]."</p>"));  
    }
    
    if(isset($json["no_auth"])){
        session_unset();
        $_SESSION["seguridad"]="Usted ha dejado de tener acceso a la API. Por favor vuelva a loguearse";
        header("Location:index.php");
        exit();
    }

    //$horario_profesor=$json["horario"];

    foreach($json["horario"] as $tupla){
        if(isset($horario_profesor[$tupla["dia"]][$tupla["hora"]])){
            $horario_profesor[$tupla["dia"]][$tupla["hora"]] .= "/". $tupla["nombre"];
        }else{
            $horario_profesor[$tupla["dia"]][$tupla["hora"]] = $tupla["nombre"];
        }
    }

}

if(isset($_POST["dia"])){
    $respuesta=consumir_servicios_REST(DIR_SERV."/gruposHorario/".$_POST["dia"]."/".$_POST["hora"]."/".$_POST["profesores"], "GET", $datos_env);
    $json=json_decode($respuesta, true);
    if(!$json){
        session_destroy();
        die(error_page("Examen2 PHP con SW","<h1>Examen2 PHP con SW</h1><p>Sin respuesta oportuna de la API desde vista_exmamen:dia</p>"));
    }
    
    if(isset($json["error"])){
        session_destroy();
        consumir_servicios_REST(DIR_SERV."/salir", "POST", $datos_env);
        die(error_page("Examen2 PHP con SW","<h1>Examen2 PHP con SW</h1><p>".$json["error"]."</p>"));  
    }
    
    if(isset($json["no_auth"])){
        session_unset();
        $_SESSION["seguridad"]="Usted ha dejado de tener acceso a la API. Por favor vuelva a loguearse";
        header("Location:index.php");
        exit();
    } 

    $grupos_horario = $json["grupos"];

    $respuesta=consumir_servicios_REST(DIR_SERV."/gruposNoHorario/".$_POST["dia"]."/".$_POST["hora"]."/".$_POST["profesores"], "GET", $datos_env);
    $json=json_decode($respuesta, true);
    if(!$json){
        session_destroy();
        die(error_page("Examen2 PHP con SW","<h1>Examen2 PHP con SW</h1><p>Sin respuesta oportuna de la API desde vista_exmamen:dia</p>"));
    }
    
    if(isset($json["error"])){
        session_destroy();
        consumir_servicios_REST(DIR_SERV."/salir", "POST", $datos_env);
        die(error_page("Examen2 PHP con SW","<h1>Examen2 PHP con SW</h1><p>".$json["error"]."</p>"));  
    }
    
    if(isset($json["no_auth"])){
        session_unset();
        $_SESSION["seguridad"]="Usted ha dejado de tener acceso a la API. Por favor vuelva a loguearse";
        header("Location:index.php");
        exit();
    } 

    $grupos_no_horario = $json["grupos"];

}


$respuesta=consumir_servicios_REST(DIR_SERV."/obtenerProfesores", "GET", $datos_env);
$json=json_decode($respuesta, true);

if(!$json){
    session_destroy();
    die(error_page("Examen2 PHP con SW","<h1>Examen2 PHP con SW</h1><p>Sin respuesta oportuna de la API desde vista_exmamen</p>"));
}

if(isset($json["error"])){
    session_destroy();
    consumir_servicios_REST(DIR_SERV."/salir", "POST", $datos_env);
    die(error_page("Examen2 PHP con SW","<h1>Examen2 PHP con SW</h1><p>".$json["error"]."</p>"));  
}

if(isset($json["no_auth"])){
    session_unset();
    $_SESSION["seguridad"]="Usted ha dejado de tener acceso a la API. Por favor vuelva a loguearse";
    header("Location:index.php");
    exit();
}

$profesores=$json["profesores"];



?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examen2 PHP con SW</title>
    <style>
        .en_linea{display:inline}
        .enlace{border:none;background:none;color:blue;text-decoration:underline;cursor:pointer}
        .mensaje{font-size:1.25em;color:blue}
        table,th, td{border:1px solid black;}
        table{border-collapse:collapse;text-align:center}
        th{background-color:#CCC}
    </style>
</head>
<body>
    <h1>Examen2 PHP con SW</h1>
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
                <p><label for="profesores">Profesores: </label>
                <select name="profesores" id="profesores">
                    <?php
                   foreach($profesores as $tupla)
                   {
                       if(isset($_POST["profesores"]) && $_POST["profesores"]==$tupla["id_usuario"])
                       {
                           echo "<option selected value='".$tupla["id_usuario"]."'>".$tupla["nombre"]."</option>";
                           $nombre_profesor=$tupla["nombre"];
                       }
                       else
                           echo "<option value='".$tupla["id_usuario"]."'>".$tupla["nombre"]."</option>";
                   }
                    ?>
                </select>
                <button type="submit" name="btnVerHorario">Ver horario</button>
        <?php
    }else{
        echo "No hay datos";
    }

    if(isset($_POST["profesores"])){

        echo "<h3>Horario del profesor: ".$nombre_profesor."</h3>";
        $horas[1]="8:15 - 9:15";
        $horas[2]="9:15 - 10:15";
        $horas[3]="10:15 - 11:15";
        $horas[4]="11:15 - 11:45";
        $horas[5]="11:45 - 12:45";
        $horas[6]="12:45 - 13:45";
        $horas[7]="13:45 - 14:45";

        $dias[]="";
        $dias[]="Lunes";
        $dias[]="Martes";
        $dias[]="Miércoles";
        $dias[]="Jueves";
        $dias[]="Viernes";

      // MOSTRAR HORARIO
      echo "<table>"; // CREAMOS LA TABLA
      echo "<tr>"; // CREAMOS LA FILA
      // COLOCAMOS LAS COLUMNAS DE DIAS
      for($i=0; $i < count($dias); $i++){
          echo "<th>".$dias[$i]."</th>";
      }
      echo "</tr>"; // CERRRAMOS LAS FILAS

      // BUCLE DE HORAS
      for($hora=1; $hora <= count($horas); $hora++){
          echo "<tr>"; // CREAMOS FILA
          echo "<th>". $horas[$hora] . "</th>"; // COLOCAMOS LAS COLUMNAS DE HORAS POR CADA FILA
          if($hora==4){
              echo "<td colspan='5'>RECREO</td>";
          }else{

              for($dia=1; $dia < count($dias); $dia++){
                  echo "<td>";
                  // SI LOS DIAS Y HORAS SON IGUALES SE IMPRIME POR PANTALLA
                  if(isset($horario_profesor[$dia][$hora])){
                      echo $horario_profesor[$dia][$hora];
                  }

                  echo "<form action='index.php' method='post'>";
                  echo "<input type='hidden' name='dia' value='". $dia . "'/>";
                  echo "<input type='hidden' name='hora' value='". $hora . "'/>";
                  echo "<input type='hidden' name='profesores' value='". $_POST["profesores"] ."'/>";
                  echo "<button class='enlace' type='submit' name='btnEditar'>Editar</button>";
                  echo "</form>";
                  echo "</td>";
              }
          }
          echo "</tr>";
      }
      echo "</table>";

        




    if(isset($_POST["dia"])){
        if($_POST["hora"]<=3){
            echo "<h2>Editando la ".$_POST["hora"]. "º hora (".$horas[$_POST["hora"]].") del " . $dias[$_POST["dia"]]. "</h2>";
        }else{
            echo "<h2>Editando la ".($_POST["hora"]-1) ."º hora (". $horas[$_POST["hora"]] . ") del " . $dias[$_POST["dia"]] . "</h2>";
        }

        if(isset($_SESSION["mensaje_accion"])){
            echo "<p class='mensaje'>".$_SESSION["mensaje_accion"]."</p>";
            unset($_SESSION["mensaje_accion"]);
        }

        echo "<table>";
        echo "<tr>
                <th>Grupo</th>
                <th>Acción</th>
            </tr>";
        foreach($grupos_horario as $tupla){
            echo "<tr>";
            echo "<td>".$tupla["nombre"]."</td>"; // NOMBRE DEL GRUPO
                echo "<td>";
                echo "<form action='index.php' method='post'>";
                echo "<input type='hidden' name='dia' value='".$_POST["dia"]."'/>";
                echo "<input type='hidden' name='hora' value='".$_POST["hora"]."'/>";
                echo "<input type='hidden' name='profesores' value='".$_POST["profesores"]."'/>";
                echo "<button type='submit' name='btnQuitar' value='".$tupla["id_horario"]."' class='enlace'>Quitar</button>"; // btnQuitar
                echo "</form>";
                echo "</td>";
            echo "</tr>";
        }
        echo "</table>";

        echo "<form action='index.php' method='post'>";
        echo "<input type='hidden' name='dia' value='" . $_POST["dia"] . "'/>";
        echo "<input type='hidden' name='hora' value='". $_POST["hora"] . "'/>";
        echo "<input type='hidden' name='profesores' value='". $_POST["profesores"] . "'/>";
        echo "<p>";
            echo "<select name='grupo'>";
            foreach($grupos_no_horario as $tupla){
                echo "<option value='" . $tupla["id_grupo"] . "'>" . $tupla["nombre"] . "</option>";
            }
            echo "</select>";
            echo "<button type='submit' name='btnAgregar'>Añadir</button>";
        echo "</p>";
        echo "</form>";

    }
    }

    ?>
</body>
</html>




