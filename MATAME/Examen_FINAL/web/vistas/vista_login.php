<?php
if(isset($_POST["btnLogin"])){
    $error_usuario=$_POST["usuario"]=="";
    $error_clave=$_POST["clave"]=="";
    $error_form=$error_usuario||$error_clave;
    if(!$error_form)
    {

        $url=DIR_SERV."/login";
        $datos["usuario"]=$_POST["usuario"];
        $datos["clave"]=md5($_POST["clave"]);
        $respuesta=consumir_servicios_REST($url,"POST",$datos);
        $json=json_decode($respuesta,true);
        if(!$json)
        {
            var_dump($json);
            session_destroy();
            die(error_page("Examen4 DWESE Curso 23-24","<h1>Notas de los alumnos</h1><p>Error consumiendo el servicio: ".$url."</p>"));
        }

        if(isset($json["error"]))
        {
            session_destroy();
            die(error_page("Examen4 DWESE Curso 23-24","<h1>Notas de los alumnos</h1><p>".$json["error"]."</p>"));
        }

        if(isset($json["mensaje"])){
            $error_usuario=true;
        }else{
            $_SESSION["usuario"]=$json["usuario"]["usuario"];
            $_SESSION["clave"]=$json["usuario"]["clave"];
            $_SESSION["tipo"]=$json["usuario"]["tipo"];
            $_SESSION["api_session"]=$json["api_session"];
            $_SESSION["ult_accion"]=time();
            $_SESSION["id_usuario"]=$json["usuario"]["id_usuario"];

            header("Location:index.php");
            exit();
            
        }

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
    <form action="index.php" method="post">
        <h1>Examen final PHP</h1>
        <label for="usuario">Usuario: </label>  
        <input type="text" name="usuario" value="<?php if(isset($_POST["usuario"])) echo $_POST["usuario"];?>">
        <?php
            if(isset($_POST["btnLogin"]) && $error_usuario){
                if($_POST["usuario"]==""){
                    echo "<span class='error'>Campo vacío</span>";
                }else{
                    echo "<span class='error'>Datos incorrectos</span>";
                }
            }
        ?>
         <label for="clave">Clave: </label>  
         <input type="password" name="clave">
         <?php
            if(isset($_POST["btnLogin"]) && $error_clave){
                if($_POST["clave"]==""){
                    echo "<span class='error'>Campo vacío</span>";
                }
            }
        ?>
        <button type="submit" name="btnLogin">Login</button>
    </form>    
    <?php
    if(isset($_SESSION["seguridad"])){
        echo "<span class='mensaje'>".$_SESSION["seguridad"]."</span>";
        session_destroy();
    }
    ?>
</body>
</html>



