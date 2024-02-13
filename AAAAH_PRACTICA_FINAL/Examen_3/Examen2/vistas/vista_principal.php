  
    <form action="index.php" method="post">
        <p>
            <label for="alumno">Seleccione un alumno: </label>
            <select name="alumno" id="alumno">
            <?php
            while($datos_alumno=mysqli_fetch_assoc($resultado))
            {
                if((isset($_POST["alumno"]) && $_POST["alumno"]==$datos_alumno["cod_alu"]) ||(isset($_SESSION["alumno"]) && $_SESSION["alumno"]==$datos_alumno["cod_alu"]) )
                {
                    echo "<option selected value='".$datos_alumno["cod_alu"]."'>".$datos_alumno["nombre"]."</option>";
                    $nombre_alumno=$datos_alumno["nombre"];
                }
                else
                    echo "<option value='".$datos_alumno["cod_alu"]."'>".$datos_alumno["nombre"]."</option>";
            }
            ?>
            </select>
            <button type="submit" name="btnVerNotas">Ver Notas</button>
        </p>
    </form>
    <?php 
        if(isset($_POST["alumno"]) || isset($_SESSION["alumno"]) )
        {
            if(isset($_SESSION["alumno"]))
                $cod_alu=$_SESSION["alumno"];
            else
                $cod_alu=$_POST["alumno"];

            echo "<h2>Notas del alumno ".$nombre_alumno."</h2>";
            
            try{
                $consulta="select asignaturas.cod_asig, asignaturas.denominacion, notas.nota from asignaturas, notas where asignaturas.cod_asig=notas.cod_asig and notas.cod_alu='".$cod_alu."'";
                $resultado=mysqli_query($conexion,$consulta);
            }
            catch(Exception $e)
            {
                mysqli_close($conexion);
                session_destroy();
                die("<p>No se ha podido realizar la consulta: ".$e->getMessage()."</p></body></html>");
            }

            echo "<table>";
            echo "<tr><th>Asignatura</th><th>Nota</th><th>Acción</th></tr>";
            while($tupla=mysqli_fetch_assoc($resultado))
            {
                echo "<tr>";
                echo "<td>".$tupla["denominacion"]."</td>";
                if((isset($_POST["btnEditarNota"]) && $_POST["btnEditarNota"]==$tupla["cod_asig"]) || (isset($_POST["btnCambiarNota"]) && $_POST["btnCambiarNota"]==$tupla["cod_asig"]) || (isset($_SESSION["asignatura"]) && $_SESSION["asignatura"]==$tupla["cod_asig"])  )
                {
                    if(isset($_POST["btnCambiarNota"]))
                        $nota=$_POST["nota"];
                    else
                        $nota=$tupla["nota"];

                    echo "<td><form action='index.php' method='post'><input type='text' name='nota' value='".$nota."'>";
                    if(isset($_POST["nota"])&& $error_form)
                        echo "<br><span class='error'>No has introducido una nota válida</span>";
                    echo "</td>";
                    echo "<td><input type='hidden' name='alumno' value='".$cod_alu."'><button class='enlace' type='submit' name='btnCambiarNota' value='".$tupla["cod_asig"]."'>Cambiar</button> - <button class='enlace' type='submit' >Atrás</button></form></td>";
                }
                else
                {
                    echo "<td>".$tupla["nota"]."</td>";
                    echo "<td><form action='index.php' method='post'><input type='hidden' name='alumno' value='".$cod_alu."'><button class='enlace' type='submit' name='btnBorrarNota' value='".$tupla["cod_asig"]."'>Borrar</button> - <button class='enlace' type='submit' name='btnEditarNota' value='".$tupla["cod_asig"]."'>Editar</button></form></td>";
                }
                echo "</tr>";
            }
            echo "</table>";

            if(isset($_SESSION["mensaje"]))
            {
                echo "<p class='mensaje'>".$_SESSION["mensaje"]."</p>";
                session_destroy();
            }

            try{
                $consulta="select * from asignaturas where cod_asig not in (select asignaturas.cod_asig from asignaturas, notas where asignaturas.cod_asig=notas.cod_asig and notas.cod_alu='".$cod_alu."')";
                $resultado=mysqli_query($conexion,$consulta);
            }
            catch(Exception $e)
            {
                mysqli_close($conexion);
                session_destroy();
                die("<p>No se ha podido realizar la consulta: ".$e->getMessage()."</p></body></html>");
            }
            if(mysqli_num_rows($resultado)>0)
            {
            ?>
                <form action="index.php" method="post">
                    <p>
                        <label for="asignatura">Asignaturas que le quedan a <?php echo $nombre_alumno;?> por calificar:</label>
                        <input type="hidden" name="alumno" value="<?php echo $cod_alu;?>">
                        <select name="asignatura" id="asignatura">
                         <?php
                         while ($tupla=mysqli_fetch_assoc($resultado))
                         {
                            echo "<option value='".$tupla["cod_asig"]."'>".$tupla["denominacion"]."</option>";
                         }
                         ?>
                        </select>
                        <button type="submit" name="btnCalificar">Calificar</button>
                    </p>
                </form>
            <?php
            }
            else
                echo "<p>A ".$nombre_alumno." no le quedan asignaturas por calificar.</p>";
        }
        ?>