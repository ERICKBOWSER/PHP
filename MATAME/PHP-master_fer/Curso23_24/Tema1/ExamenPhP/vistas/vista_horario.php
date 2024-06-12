<?php
$options="";
while($linea=fgets($fd))
{
    $datos_linea=mi_explode("\t",$linea);
    if(isset($_POST["btnVerHorario"])&& $_POST["profesor"]==$datos_linea[0])
    {
        $options.="<option selected value='".$datos_linea[0]."'>".$datos_linea[0]."</option>";
        $nombre_prof=$datos_linea[0];
        for($i=1;$i<count($datos_linea);$i+=3)
        {
            if(isset($horario_profe[$datos_linea[$i]][$datos_linea[$i+1]]))
                $horario_profe[$datos_linea[$i]][$datos_linea[$i+1]].="/".$datos_linea[$i+2];
            else
                $horario_profe[$datos_linea[$i]][$datos_linea[$i+1]]=$datos_linea[$i+2];
        }

    }
    else
        $options.="<option value='".$datos_linea[0]."'>".$datos_linea[0]."</option>";
}
fclose($fd);
?>

<h2>Horario de los profesores</h2>
<form action="Examen4.php" method="post">
    <p>
        <label for="profesor">Horario del Profesor </label>
        <select name="profesor" id="profesor">
        <?php
            echo $options;
        ?>
        </select>
        <button name="btnVerHorario" type="submit">Ver Horario</button>
    </p>
</form>
<?php
if(isset($_POST["btnVerHorario"]))
{
    echo "<h3 class='text_centrado'>Horario del Profesor: ".$nombre_prof."</h3>";

    $horas[1]="8:15-9:15";
    $horas[]="9:15-10:15";
    $horas[]="10:15-11:15";
    $horas[]="11:15-11:45";
    $horas[]="11:45-12:45";
    $horas[]="12:45-13:45";
    $horas[]="13:45-14:45";

    echo "<table>";
    echo "<tr><th></th><th>Lunes</th><th>Martes</th><th>Miércoles</th><th>Jueves</th><th>Viernes</th></tr>";
    for($hora=1;$hora<=7;$hora++)
    {
        echo "<tr>";
        echo "<th>".$horas[$hora]."</th>";
        if($hora==4)
        {
            echo "<td colspan='5'>RECREO</td>";
        }
        else
        {
            for($dia=1;$dia<=5;$dia++)
            {
                if(isset($horario_profe[$dia][$hora]))
                {
                    echo "<td>".$horario_profe[$dia][$hora]."</td>";
                }
                else
                {
                    echo "<td></td>";
                }
            } 
        }
        echo "</tr>";
    }
    echo "</table>";



}
?>