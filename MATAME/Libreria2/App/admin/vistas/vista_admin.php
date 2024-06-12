
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div>
        <h1>Libreria</h1>
        <form action="index.php" method="post">
            <p>
                <label for="usuario">Usuario: </label>
                <input type="text" name="usuario" id="usuario" value="<?php if(isset($_POST["usuario"])) echo $_POST["usuario"];?>">
                <?php
                if(isset($_POST["btnEntrar"]) && $error_usuario){
                    if($_POST["usuario"]==""){
                        echo "<span class='error'>Campo vacío</span>";
                    }else{
                        echo "<span class='error'>Datos incorrectos</span>";
                    }
                }
                ?>
            </p>
            <p>
                <label for="clave">Clave: </label>
                <input type="password" name="clave" id="clave">
                <?php
                if(isset($_POST["btnEntrar"]) && $error_clave){
                    if($_POST["clave"] == ""){
                        echo "<span class='error'>Campo vacío</span>";
                    }
                }
                ?>
            </p>
            <button type="submit" name="btnEntrar" id="btnEntrar">Entrar</button>
        </form>
    </div>    
    <?php
    if(isset($_SESSION["seguridad"])){
        echo "<p class='mensaje'>".$_SESSION["seguridad"]."</p>";
        session_destroy();
    }
    ?>
</body>
</html>