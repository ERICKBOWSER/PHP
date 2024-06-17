<?php
if(isset($_POST["todosGrupos"]))
{
    $respuesta=consumir_servicios_REST(DIR_SERV."/horarioGrupo/".$_POST["todosGrupos"],"GET",$datos_env);
    $json=json_decode($respuesta,true);
    
    if(!$json)
    {
     session_destroy();
     die(error_page("Examen Final PHP","<h1>Examen Final PHP</h1><p>Error consumiendo el servicio: API horario Profesor</p>"));
    }
    if(isset($json["error"]))
    {
     session_destroy();
     die(error_page("Examen Final PHP","<h1>Examen Final PHP</h1><p>El mensaje error es: ".$json["error"]."</p>"));
    }
    $grupos=$json["grupos"];
 
}

$respuesta=consumir_servicios_REST(DIR_SERV.'/todosGrupos',"GET",$datos_env);
$json=json_decode($respuesta,true);

if(!$json)
{
 session_destroy();
 die(error_page("Examen Final PHP","<h1>Examen Final PHP</h1><p>Error consumiendo el servicio: API horario Profesor</p>"));
}
if(isset($json["error"]))
{
 session_destroy();
 die(error_page("Examen Final PHP","<h1>Examen Final PHP</h1><p>El mensaje error es: ".$json["error"]."</p>"));
}
$todos_grupos=$json["todos_grupos"];


?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examen Final PHP</title>
    <style>
        .en_linea {
            display: inline
        }

        .enlace {
            border: none;
            background: none;
            color: blue;
            text-decoration: underline;
            cursor: pointer
        }

        .mensaje {
            font-size: 1.25em;
            color: blue
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        table {
            border-collapse: collapse;
            text-align: center
        }

        th {
            background-color: #CCC
        }

        .horas {
            background-color: #CCC
        }
    </style>
</head>

<body>
    <h1>Examen Final PHP</h1>
    <div>
        Bienvenido <strong><?php echo $datos_usuario_log["usuario"]; ?></strong> -
        <form class="en_linea" action="index.php" method="post">
            <button class="enlace" name="btnSalir" type="submit">Salir</button>
        </form>
    </div>
   
   <form action="index.php" method="post">
        <select name="todosGrupos" id="todosGrupos">
          <?php
            foreach($todos_grupos as $tupla)
            {
              echo"<option  value='".$tupla["id_grupo"]."'>".$tupla["nombre"]. "</option>";
                
            }
          ?>
        
        </select>
    <button type="submit" name="btnVerHorario">Ver Horario</button>
   </form>

   <?php
   
   $dias[0]="";
   $dias[1]="Lunes";
   $dias[2]="Martes";
   $dias[3]="Miercoles";
   $dias[4]="Jueves";
   $dias[5]="Viernes";

   $horas[1]="8:15-9:15";
   $horas[2]="9:15-10:15";
   $horas[3]="10:15-11:15";
   $horas[4]="11:15-11:45";
   $horas[5]="11:45_12:45";
   $horas[6]="12:45-13:45";
   $horas[7]="13:45-14:45";

   echo "<table>";
   echo"<tr>";
   for ($i=0; $i <count($dias) ; $i++) { 
       echo"<th>".$dias[$i]."</th>";
   }
   echo"</tr>";
  
   for ($hora=1; $hora <=7 ; $hora++) { 
       echo"<tr>";
       echo"<td>".$horas[$hora]."</td>";
         if($hora==4)
         {
           echo"<td colspan='5'>RECREO</td>";
         }
         else
         {
           for ($dia=1; $dia <=5 ; $dia++) { 
               echo"<td>";
             for ($i=0; $i <count($grupos) ; $i++) { 
               if($grupos[$i]["dia"]==$dia && $grupos[$i]["hora"]==$hora)
               {
                 echo "".$grupos[$i]["nombre"];  
                 echo "(".$grupos[$i]["aula"].")<br/>";  
               }
             }
             echo "<form action='index.php' method='post'>";
             echo "<button class='enlace' type='submit' name='btnEditar'>Editar</button>";
             echo "<input type='hidden' name='dia' value='" . $dia . "'>";
             echo "<input type='hidden' name='hora' value='" . $hora . "'>";
             echo "<input type='hidden' name='grupos' value='" . $_POST["todosGrupos"] . "'>";
             echo "<input type='hidden' name='btnVerHorarios' value='" . $_POST["todosGrupos"] . "'>";

             echo "</form>";
             echo"</td>";
             }
         }
         
    echo"</tr>";
   }
   echo "</table>";

   
   
   ?>


</body>

</html>