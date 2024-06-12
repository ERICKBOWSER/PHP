<?php
require "src/funciones.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>Repaso</h1>
    <?php

    if(!$conexion){
        try {
            $conexion = mysqli_connect(SERVIDOR_BD,USUARIO_BD,CLAVE_BD,NOMBRE_BD);
            mysqli_set_charset($conexion,"utf8");
        } catch (Exception $e) {
            die("<p>No se ha podido conecto a la bd:".$e->getMessage()."</p></body></html>");
        }
    }
    
    try {
        $consulta= "select * from usuarios";
        $resultado =mysqli_query($conexion,$consulta);
    } catch (Exception $e) {
        die("<p>No se ha podido realizar la consulta:".$e->getMessage()."</p></body></html>");
    }



    if(mysqli_num_rows($resultado)>0){


        echo "<p>Listado de los usuarios</p>";
        echo "<table>";
        echo "<tr><th>Dato1</th><th>Dato1</th><th>Dato1</th><th>Dato1</th></tr>";
        while ($tupla=mysqli_fetch_assoc($resultado)) {
            echo "<tr>";
            echo "<td>".$tupla["nombre"]."</td>";
            echo "<td><form action='index.php' method='post'><button class='enlace' type='submit' name='btnDetalle' value='".$tupla["idusuario"]."' ></button></form></td>";
            echo "<td><form action='index.php' method='post'><input type='hidden' name='nombreFoto' value='".$tupla["foto"]."'/><button class='enlace' type='submit' name='btnDetalle' value='".$tupla["idusuario"]."' ></button></form></td>";
            echo "</tr>";
        }
        echo "</table>";



    }else{
        echo "<p>No existen registros en la tabla actualmente</p>";
    }

    mysqli_free_result($resultado);
    mysqli_close($conexion);


    if(isset($_POST["btnDetalle"])){
        

        echo "<h1>Datos del usuario con id usuario: ".$_POST["btnDetalle"]."</h1>";


        if(!$conexion){
            try {
                $conexion = mysqli_connect(SERVIDOR_BD,USUARIO_BD,CLAVE_BD,NOMBRE_BD);
                mysqli_set_charset($conexion,"utf8");
            } catch (Exception $e) {
                die("<p>No se ha podido conecto a la bd:".$e->getMessage()."</p></body></html>");
            }
        }
        
        try {
            $consulta= "select * from usuarios where idusuario='".$_POST["btnDetalle"]."'";
            $resultado =mysqli_query($conexion,$consulta);
        } catch (Exception $e) {
            die("<p>No se ha podido realizar la consulta:".$e->getMessage()."</p></body></html>");
        }

        $datos_usuario = mysqli_fetch_assoc($resultado);
        mysqli_free_result($resultado);

        echo "<p>Nombre: ".$datos_usuario["nombre"]."</p>";
        echo "<p>Nombre: ".$datos_usuario["nombre"]."</p>";
        echo "<p>Nombre: ".$datos_usuario["nombre"]."</p>";
        echo "<p>Nombre: ".$datos_usuario["nombre"]."</p>";





        echo "<form action='index.php' method='post'>";
        echo "<button type='submit'>Atras</button>";
        echo "</form>";

    }


    if(isset($_POST["btnBorrar"])){
        echo "<p>Se dispone a borrar al usuario con id:".$_POST["btnBorrar"]."</p>";
        echo "<form action='index.php' method='post'>";
        echo "<button type='submit' name='btnContBorrar' value='".$_POST["btnBorrar"]."'>Continuar</button>";
        echo "<button type='submit'>Atras</button>";
        echo "</form>";
    }


    
    if(isset($_POST["btnContBorrar"])){


        if(!$conexion){
            try {
                $conexion = mysqli_connect(SERVIDOR_BD,USUARIO_BD,CLAVE_BD,NOMBRE_BD);
                mysqli_set_charset($conexion,"utf8");
            } catch (Exception $e) {
                die("<p>No se ha podido conecto a la bd:".$e->getMessage()."</p></body></html>");
            }
        }
        
        try {
            $consulta= "delete * from usuarios where idusuario='".$_POST["btnContBorrar"]."'";
            $resultado =mysqli_query($conexion,$consulta);
        } catch (Exception $e) {
            die("<p>No se ha podido realizar la consulta:".$e->getMessage()."</p></body></html>");
        }

        mysqli_close($conexion);
        header("Location:index.php");
        exit();

    }



    if(isset("btnNuevo")){
        ?>
        <h1>Agregar nuevo usuario</h1>

        <form action="index.php" method="post">

        <p>
            <label for="usuario">Nombre de Usuario:</label></br>
            <input type="text" id="usuario" name="usuario" value="<?php if(isset($_POST["usuario"])) echo $_POST["usuario"];?>"></input>

            <?php
                if(isset($_POST["usuario"]) && $error_usuario){

                    if($_POST["usuario"]==""){
                        echo "<span class='error'>Rellene el campo por favor</span>";
                    }

                }
            ?>
        </p>


        </form>

        <?php
    }






    ?>










</body>

</html>