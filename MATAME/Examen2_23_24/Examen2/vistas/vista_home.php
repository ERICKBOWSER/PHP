

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examen 2</title>
    <style>
        
        .error{
            color:red
        }
        .mensaje{
            color:blue;
            font-size:1.25em;
        }
    </style>
</head>
<body>
<h1>Examen2 PHP</h1>
<h2>Horario de los Profesores</h2>

<form action="index.php" method="post">
    <p>
        <label for="usuario">Usuario:</label>
        <input type="text" id="usuario" name="usuario" value="<?php if(isset($_POST["usuario"])) echo $_POST["usuario"];?>">
        <?php
        if(isset($_POST["btnLogin"]) && $error_usuario){
            if($_POST["usuario"]==""){
                echo "<span class='error'>Campo vacío</span>";
            }else{
                echo "<span class='error'>Usuario/clave incorrectos</span>";
            }
        }
        ?>
    </p>
    <p>
        <label for="clave">Contraseña: </label>
        <input type="password" id="clave" name="clave">
        <?php
        if(isset($_POST["btnLogin"]) && $error_clave){
            echo "<span class='error'>Campo vacío</span>";
        }
        ?>
    </p>
    <p>
        <button type="submit" name="btnLogin">Login</button>
    </p>
</form>
<?php 
    if(isset($_SESSION["seguridad"])){
        echo "<p class='mensaje'>".$_SESSION["seguridad"]."</p>";
        session_destroy();
    }
?>
    
</body>
</html>