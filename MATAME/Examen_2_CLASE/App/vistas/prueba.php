    <?php
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