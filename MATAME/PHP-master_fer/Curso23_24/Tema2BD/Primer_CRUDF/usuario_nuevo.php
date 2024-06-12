<?php

    require "src/const_funciones.php";

    if(isset($_POST["btnNuevoUsuario"]) || isset($_POST["continuar"])){

        if(isset($_POST["continuar"])){ //compruebo errores



            //ERROR NOMBRE
            $error_nombre=$_POST["nombre"]=="" || strlen($_POST["nombre"]) > 30;



            //ERROR USUARIO
            $error_usuario=$_POST["usuario"]=="" || strlen($_POST["usuario"]) > 20;

            if(!$error_usuario){

                try{
            
                    $conexion=mysqli_connect("localhost","jose","josefa","bd_foro");
                    mysqli_set_charset($conexion,"utf8");
        
                }catch(Exception $e){
                    //LE PASO LOS 2 PARAMETROS TITLE Y BODY
                    die(error_page("Practica 1º CRUD","<h1>Practica 1º CRUD</h1><p>No ha podido conectarse a la base de datos: ".$e->getMessage()."</p></body></html>"));
                }

               
                $error_usuario=repetido($conexion,"usuarios","usuario",$_POST["usuario"]);
                if(is_string($error_usuario)){
                    die($error_usuario);
                }

            }


            //ERROR CLAVE
            $error_clave=$_POST["clave"]=="" || strlen($_POST["clave"]) > 15;





            //ERROR EMAIL
            $error_email=$_POST["email"]== "" || strlen($_POST["email"]) > 50 || !filter_var($_POST["email"],FILTER_VALIDATE_EMAIL);


            if(!$error_email){
                if(!isset($conexion)){

                    try{
            
                        $conexion=mysqli_connect("localhost","jose","josefa","bd_foro");
                        mysqli_set_charset($conexion,"utf8");
            
                    }catch(Exception $e){
                        //LE PASO LOS 2 PARAMETROS TITLE Y BODY
                        die(error_page("Practica 1º CRUD","<h1>Practica 1º CRUD</h1><p>No ha podido conectarse a la base de datos: ".$e->getMessage()."</p></body></html>"));
                    }
                }

                $error_usuario=repetido($conexion,"usuarios","email",$_POST["email"]);
                if(is_string($error_email)){
                    die($error_email);
                }
            }



            //ERROR DEL FORMULARIO
            $error_form= $error_nombre || $error_usuario ||  $error_clave || $error_email; 



            if(!$error_form){


                try {
        
                    $consulta="insert into usuarios (nombre,usuario,clave,email) values ('".$_POST["nombre"]."','".$_POST["usuario"]."','".md5($_POST["clave"])."','".$_POST["email"]."')";
                    mysqli_query($conexion,$consulta); //COMO ES UN INSERT NO SE RECOGEN EN LA VARIABLE $RESULTADO
                    
                } catch (Exception $e) {
            
                    mysqli_close($conexion);
                    die(error_page("Practica 1º CRUD","<h1>Practica 1º CRUD</h1><p>No ha podido hacer la consulta: ".$e->getMessage()."</p></body></html>"));
                }

                mysqli_close($conexion);

                //inserto en BD y salto a index"
                header("Location:index.php");
                exit;
            }

            if(isset($conexion)){
                mysqli_close($conexion);
            }

        }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .error{color:red;}
    </style>
</head>
<body>
    <h1>Nuevo Usuario</h1>
    <form action="usuario_nuevo.php" method="post" enctype="multipart/form-data">
        <p>
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" id="nombre" maxlength="30" value="<?php if(isset($_POST["nombre"])) echo $_POST["nombre"] ?>">


            <?php
                if(isset($_POST["continuar"]) && $error_nombre){
                    if($_POST["nombre"] == ""){
                        echo "<span class='error'> Campo vacio</span>";
                    }else{
                        echo "<span class='error'> Has tecleado mas de 30 caracteres</span>";
                    }
                }

            ?>
        </p>

        <p>
            <label for="usuario">Usuario:</label>
            <input type="text" name="usuario" id="usuario" maxlength="20" value="<?php if(isset($_POST["usuario"])) echo $_POST["usuario"] ?>">
            <?php
                if(isset($_POST["continuar"]) && $error_usuario){
                    if($_POST["usuario"] == ""){
                        echo "<span class='error'> Campo vacio</span>";
                    }elseif($_POST["usuario"] > 20){
                        echo "<span class='error'> Has tecleado mas de 20 caracteres</span>";
                    }else{
                        echo "<span class='error'>Usuario repetido</span>";
                    }
                }

            ?>
        </p>

        <p>
            <label for="clave">Contraseña:</label>
            <input type="password" name="clave" maxlength="15" id="clave">
            <?php
                if(isset($_POST["continuar"]) && $error_clave){
                    if($_POST["clave"] == ""){
                        echo "<span class='error'> Campo vacio</span>";
                    }else{
                        echo "<span class='error'> Has tecleado mas de 15 caracteres</span>";
                    }
                }

            ?>
        </p>

        <p>
            <label for="email">Email:</label>
            <input type="text" name="email" id="email" maxlength="50" value="<?php if(isset($_POST["email"])) echo $_POST["email"] ?>">
            <?php
                if(isset($_POST["continuar"]) && $error_email){
                    if($_POST["email"] == ""){
                        echo "<span class='error'> Campo vacio</span>";
                    }elseif(strlen($_POST["email"])>50){

                        echo "<span class='error'> Has tecleado mas de 50 caracteres</span>";

                    }elseif(!filter_var($_POST["email"],FILTER_VALIDATE_EMAIL)){

                        echo "<span class='error'>Email sintaxticamente incorrecto</span>";

                    }else{
                        echo "<span class='error'>Email repetido</span>";
                    }
                }

            ?>
        </p>

        <p>
            <button type="submit" name="continuar">Continuar</button>
            <button type="submit" name="volver">Volver</button>
        </p>
    </form>
</body>
</html>
<?php

}else{
    //POR SI NO PULSO EL BOTON Y LE METO UN INTRO A LA BARRA DE BUSQUEDA DE ARRIBA LO MANDO A INDEX
    header("Location:index.php");
    exit;
}
?>