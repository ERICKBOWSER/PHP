<?php

if(!isset($conexion)){
    try{
        $conexion=mysqli_connect("localhost", "jose", "josefa", "bd_exam_colegio");
        mysqli_set_charset($conexion, "utf8");
    }catch(Exception $e){
        die("<p>No ha podido conectarse a la base de datos: " .$e ->getMessage(). "</p></body></html>");
    }
}

try{
    $consulta = "SELECT * FROM alumnos";
    $resultado = mysqli_query($conexion, $consulta);
}catch(Exception $e){
    mysqli_close($conexion);
    die("<p>No se ha podido realizar la consulta: " . $e->getMessage() . "</p></body></html>");
}

echo "<h1>Notas de los alumnos</h1>";
echo "<label for='nombres'>Seleccione un alumno:</label>";
echo "<select>";

while($tupla=mysqli_fetch_assoc($resultado)){
    if(isset($_POST["nombres"]) && $_POST["nombres"] == $tupla["cod_alu"]){
        echo "<option selected>" . $tupla["nombre"] ."</option>";
        $nombreAlu = $tupla["nombre"];
    }else{
        echo "<option>" . $tupla["nombre"] ."</option>";
    }
}
echo "</table>";
mysqli_free_resutl($resultado);

?>






