<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Librería</title>
    <style>
        #libros{
            display:flex;
            justify-content: space-between;
            flex-flow: wrap;
            width: 90%;
        }
        #libros div{
            flex: 33% 0;
            text-align: center;
        }
        #libros div img{
            width: 100%;
            height: auto;
        }
        
    </style>
</head>
<body>
    <h1>Librería</h1>
    <form method="post" action="index.php">
        <p>
            <label for="">Nombre de usuario</label>
            <input type="text" name="usuario" id="usuario" value="<?php if(isset($_POST["usuario"])) echo $_POST["usuario"] ?>"/> <!-- SI EL USUARIO HA SIDO ENVIADO MUESTRALO-->
        </p>
        <p>
            <label for="clave">Contraseña:</label>
            <input type="password" name="clave" id="clave"/>
        </p>
        <p>
            <button name="btnEntrar">Entrar</button>
        </p>      
    </form>    
    <h2>Listado de libros</h2>
    <?php 
        $url = DIR_SERV. "/obtenerLibros";
        $respuesta = consumir_servicios_REST($url, "GET"); // INDICAMOS LA URL Y PORQUE METODO LO VAMOS A USAR
        $obj = json_decode($respuesta); // DEVUELVE UN STRING DE JSON EN UNA VARIABLE DE PHP
        
        // SI NO ES UN OBJETO
        if(!$obj){
            session_destroy();
            die("<p>Error consumiendo el servicio: " . $url . "</p></body></html>");
        }

        // SI EL OBJETO OBTENIDO ES UN ERROR...
        if(isset($obj->error)){
            session_destroy();
            die("<p>Error consumiendo el servicio: " . $url . "</p></body></html>");
        }

        echo "<div id='libros'>";

        foreach($obj-> libros as $tupla){
            echo "<div>";
            echo "<img src='images/'" . $tupla -> portada . " alt='" . $tupla->titulo . "' title='" . 
                $tupla-> titulo . "'/><br>" . $tupla -> titulo . " - " $tupla->precio . "€";
            echo "</div>";
        }

        echo "</div>";

    ?>  

</body>
</html>