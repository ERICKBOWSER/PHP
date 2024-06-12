<?php
//No estoy logueado
    if(isset($_POST["btnEntrar"]))
    {
        $error_usuario=$_POST["usuario"]=="";
        $error_clave=$_POST["clave"]=="";
        $error_form=$error_usuario||$error_clave;
        if(!$error_form)
        {
            try{
                $consulta="select * from usuarios where lector='".$_POST["usuario"]."' and clave='".md5($_POST["clave"])."'";
                $resultado=mysqli_query($conexion,$consulta);
            }
            catch(Exception $e)
            {
                session_destroy();
                mysqli_close($conexion);
                die(error_page("Examen3 Curso 23-24","<h1>Librería</h1><p>No se ha podido realizar la consulta: ".$e->getMessage()."</p>"));
            }
            
            if(mysqli_num_rows($resultado)>0)
            {
                $_SESSION["usuario"]=$_POST["usuario"];
                $_SESSION["clave"]=md5($_POST["clave"]);
                $_SESSION["ultima_accion"]=time();
                $datos_usu_log=mysqli_fetch_assoc($resultado);
                mysqli_free_result($resultado);
                mysqli_close($conexion);

                if($datos_usu_log["tipo"]=="normal")
                {
                    header("Location:index.php");
                }
                else
                {
                    header("Location:admin/gest_libros.php");
                }
                exit();
            }
            else
                $error_usuario=true;
         
            mysqli_free_result($resultado);
        }

    }


?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Examen3 Curso 23-24</title>
        <style>
            img{height:200px}
            p.libros{text-align:center;width:30%;margin-top:2.5%;margin-left:2.5%;float:left}
        </style>
    </head>
    <body>
        <h1>Librería</h1>
        <form action="index.php" method="post">
            <p>
                <label for="usuario">Usuario:</label>
                <input type="text" name="usuario" id="usuario" value="<?php if(isset($_POST["usuario"])) echo $_POST["usuario"];?>">
                <?php
                if(isset($_POST["usuario"])&& $error_usuario)
                    if($_POST["usuario"]=="")
                        echo "<span class='error'> Campo vacío</span>"; 
                    else
                        echo "<span class='error'> Usuario/clave incorrectos</span>"; 
                ?>
            </p>
            <p>
                <label for="clave">Contraseña:</label>
                <input type="password" name="clave" id="clave">
                <?php
                if(isset($_POST["clave"])&& $error_clave)
                    echo "<span class='error'> Campo vacío</span>";    
                ?>
            </p>
            <p>
                <button type="submit" name="btnEntrar">Entrar</button>
            </p>
        </form>
        <?php
        if(isset($_SESSION["seguridad"]))
        {
            echo "<p class='mensaje'>".$_SESSION["seguridad"]."</p>";
            session_destroy();
        }


        require "vistas/vista_libros_atres.php";
        ?>
    </body>
    </html>
