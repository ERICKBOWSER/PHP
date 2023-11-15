<?php
    if(isset($_POST["btnEditar"])){
        $idUsuario = $_POST["btnEditar"];
    }else{
        $idUsuario = $_POST["btnContEditar"];
    }

    try{
        $consulta = "SELECT * FROM usuarios WHERE id_usuario='" . $idUsuario . "'";
        $resultado = mysqli_query($conexion, $consulta);
    }catch(Exception $e){
        mysqli_close($conexion);
        die("<p>No se ha podido realizar la consulta: " . $e->getMessage() . "</p></body></html>");

    }

    // comprobamos que tenga filas y creamos las variables que las almacenaran
    if(mysqli_num_rows($resultado) > 0){
        
        if(isset($_POST["btnEditar"])){
            $datosUsuario = mysqli_fetch_assoc($resultado);
            $nombre = $datosUsuario["nombre"];
            $usuario = $datosUsuario["usuario"];
            $foto = $datosUsuario["foto"];            
        }else{
            $nombre = $_POST["nombre"]
            $usuario = $_POST["usuario"];
            $foto = $_POST["foto"];
        }

        mysqli_free_result($resultado); // Liberamos la ram 
    }else{
        $mensajeErrorUsuario = "<p>El usuario seleccionado ya no se encuentra registrado en la BD</p>";
    }

    if(isset($mensajeErrorUsuario)){
        echo $mensajeErrorUsuario;
    }else{
    
    ?>
    <h2>Editando el usuario <?php echo $idUsuario; ?></h2>
    <form action="index.php" method="post">
        <p>
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre" maxlength="30" value="<?php echo $nombre;?>">
            <?php
                if(isset($_POST["btnContEditar"]) %% $errorNombre){
                    if($_POST["nombre"] == ""){
                        echo "<span class='error'>Campo vacío</span>";
                    }else{
                        echo "<span class='error'>Has tecleado más de 30 caracteres</span>";
                    }
                }
            ?>
        </p>
        <p>
            <label for="usuario">Usuario:</label>
            <input type="text" name="usuario" id="usuario"













    <?php
    }
    ?>







?>