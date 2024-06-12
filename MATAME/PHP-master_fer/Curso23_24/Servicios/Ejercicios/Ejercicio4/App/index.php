<?php
if(isset($_POST["btnInsertar"])){
    echo "<input>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplicacion web de prueba de servicios</title>
    <style> table,td,th{border:1px solid black;}
        table{border-collapse:collapse;text-align:center;width:90%;margin:0 auto}
        th{background-color:#CCC}
        table img{width:50px;}
        h1{
            text-align: center;
        }
        .enlace{border:none;background:none;cursor:pointer;color:blue;text-decoration:underline}
        </style>
</head>

<body>
    <?php
     define("DIR_SERV","http://localhost/Proyectos/PHP/Curso23_24/Servicios/Ejercicios/Ejercicio4/servicios_rest");


    function consumir_servicios_REST($url, $metodo, $datos = null)
    {
        $llamada = curl_init();
        curl_setopt($llamada, CURLOPT_URL, $url);
        curl_setopt($llamada, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($llamada, CURLOPT_CUSTOMREQUEST, $metodo);
        if (isset($datos))
            curl_setopt($llamada, CURLOPT_POSTFIELDS, http_build_query($datos));
        $respuesta = curl_exec($llamada);
        curl_close($llamada);
        return $respuesta;
    }
    $url = DIR_SERV . "/productos";
    $respuesta = consumir_servicios_REST($url, "GET");
    $obj = json_decode($respuesta);
    if (!$obj)
        die("<p>Error consumiendo el servicio: " . $url . "<p>" . $respuesta);

    if (isset($obj->mensaje_error))
        die("<p>" . $obj->mensaje_error . "<p></body></html>");
    
    echo "<h1>Lista de productos</h1>";
    echo "<table>";
    echo "<tr><th>Cod</th><th>Nombre</th><th>PVP</th><th><form action='index.php' method='post'><button class='enlace' type='submit' name='btnNuevoProducto'>Productos+</button></form></th></tr>";

    foreach($obj->productos as $tupla){
        echo "<tr>";
        echo "<td><form action='index.php' method='post'><form action='index.php' method='post'><button class='enlace' type='submit' name='btnverproducto'>".$tupla->cod."</button></form></td>";
        echo "<td>".$tupla->nombre_corto."</td>";
        echo "<td>".$tupla->PVP."</td>";
        echo "<td><form action='index.php' method='post'><button class='enlace' type='submit' value='".$tupla->cod."' name='btnBorrar'>Borrar</button> - <button class='enlace' type='submit' value='".$tupla->cod."' name='btnEditar'>Editar</button></form></td>";
        echo "</tr>";
    }

    echo "</table>";
    ?>
    
</body>

</html>