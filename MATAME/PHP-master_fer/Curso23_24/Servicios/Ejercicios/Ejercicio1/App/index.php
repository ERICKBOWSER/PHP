<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>APlicacion web de Prueba de Servicios</title>
</head>
<body>
    <?php
    define("DIR_SERV","http://localhost/Proyectos/PHP/Curso23_24/Servicios/Ejercicios/Ejercicio1/servicios_rest");

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
    $datos["cod"] = "ZAZAZA";
    $datos["nombre"] = "prueba de producto";
    $datos["nombre_corto"] = "prueba";
    $datos["descripcion"] = "blabllasldfdffkfsdasdsdkfsdfjsdkffs";
    $datos["PVP"] = 24.3;
    $datos["familia"] = "MP3";

    //INSERTAR
   /* $url = DIR_SERV . "/producto/insertar";
    $respuesta = consumir_servicios_REST($url, "post", $datos);
    $obj = json_decode($respuesta);
    if (!$obj)
        die("<p>Error consumiendo el servicio: " . $url . "<p>" . $respuesta);

    if (isset($obj->mensaje_error))
        die("<p>" . $obj->mensaje_error . "<p></body></html>");

    echo "<p>" . $obj->mensaje . "</p>";*/

    //ACTUALIZAR
   /* $url = DIR_SERV . "/producto/actualizar/" . urlencode("TNI");
    $respuesta = consumir_servicios_REST($url, "put", $datos);
    $obj = json_decode($respuesta);
    if (!$obj)
        die("<p>Error consumiendo el servicio: " . $url . "<p>" . $respuesta);

    if (isset($obj->mensaje_error))
        die("<p>" . $obj->mensaje_error . "<p></body></html>");

    echo "<p>" . $obj->mensaje . "</p>";*/

    //DELETE
    /*$url = DIR_SERV . "/producto/borrar/" . urlencode("ACERAX3950");
    $respuesta = consumir_servicios_REST($url, "DELETE");
    $obj = json_decode($respuesta);
    if (!$obj)
        die("<p>Error consumiendo el servicio: " . $url . "<p>" . $respuesta);

    if (isset($obj->mensaje_error))
        die("<p>" . $obj->mensaje_error . "<p></body></html>");

    echo "<p>" . $obj->mensaje . "</p>";*/



    
    $url = DIR_SERV . "/productos";
    $respuesta = consumir_servicios_REST($url, "GET");
    $obj = json_decode($respuesta);
    if (!$obj)
        die("<p>Error consumiendo el servicio: " . $url . "<p>" . $respuesta);

    if (isset($obj->mensaje_error))
        die("<p>" . $obj->mensaje_error . "<p></body></html>");

    echo "<table>";
    echo "<tr><th>Cod</th><th>Nombre Corto</th></tr>";


    echo "<h1>Nombre ejemplo: ".$obj->productos[0]->nombre_corto."</h1>";
    echo "<p>El numero de tuplas obtenidas ha sido: ".count($obj->productos)."</p>";

    foreach($obj->productos as $tupla){
        echo "<tr>";
        echo "<td>".$tupla->cod."</td>";
        echo "<td>".$tupla->nombre_corto."</td>";
        echo "</tr>";
    }

    echo "</table>";

        
    $url = DIR_SERV . "/producto/KSTMSDHC8GB";
    $respuesta = consumir_servicios_REST($url, "GET");
    $obj = json_decode($respuesta);
    if (!$obj)
        die("<p>Error consumiendo el servicio: " . $url . "<p>" . $respuesta);

    if (isset($obj->mensaje_error))
        die("<p>" . $obj->mensaje_error . "<p></body></html>");

        echo "<h1>Nombre corto de KSTMSDHC8GB es : ".$obj->producto->nombre_corto."</h1>";


    ?>
</body>
</html>