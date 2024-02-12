<?php

// CARGAMOS LOS FICHEROS QUE VAMOS A NECESITAR Y QUEREMOS QUE SE CARGUEN PRIMERO
require "src/funciones_servicios.php";
require __DIR__ . "Slim/autoload.php";

$app = new \Slim\App;

// ESTABLECEMOS LA CONEXION USANDO PDO Y CON EL METODO GET
$app->get('/conexion_PDO', function($request){
    echo json_decode(conexion_pdo()); // DECODIFICA UN JSON STRING EN UN VALOR PHP
});

$app->get('/conexion_MYSQLI', function($request){
    echo json_decode(conexion_mysqli());
});

$app->post('/login', function($request){
    $lector = $request->getParam("lector");
    $clave = $request->getParam("clave");

    echo json_encode(login($lector, md5($clave))); // CODIFICA Y REGRESA UN JSON, TAMBIÉN SE CODIFICA LA CLAVE CON md5
});

$app->get('/logueado', function($request){
    $token = $request ->getParam("api_session");

    session_id($token);
    session_start();

    if(isset($_SESSION["usuario"])){
        echo json_encode(logueado($_SESSION["usuario"], $_SESSION["clave"]));
    }else{
        session_destroy();
        echo json_encode(array("no_auth" => "No tienes permisos para usar este servicio")); 
    }

    
});

$app->post('/crearLibro', function($request){
    $token = $request -> getParam("api_session"); 
    session_id($token);
    session_start();

    // SI EL USUARIO ES ADMIN
    if(isset($_SESSION["tipo"]) && $_SESSION["tipo"] == "admin"){
        $datos[] = $request->getParam("referencia");
        $datos[] = $request->getParam("titulo");
        $datos[] = $request->getParam("autor");
        $datos[] = $request->getParam("descripcion");
        $datos[] = $request->getParam("precio");

        echo json_encode(crear_libro($datos));
    }else{
        echo json_encode(array("no_auth" => "No tienes permisos para usar este servicio"));
    }

});

$app -> put('/actualizarPortada/{referencia}', function($request){
    $token = $request ->getParam("api_session");
    session_id($token);
    session_start();

    if(isset($_SESSION["tipo"]) && $_SESSION["tipo"] == "admin"){
        $datos[] = $request->getParam("portada");
        $datos[] = $request->getAttribute("referencia");
    }else{
        echo json_encode(array("no_auth" => "No tienes permisos para usar este servicio"));
    }
});

$app->get('/repetido/{tabla}/{columna}({valor}', function($request){
    $token = $request->getParam("api_session");
    session_id($token);
    session_start();

    if(isset($_SESSION["tipo"]) && $_SESSION["tipo"] == "admin"){
        echo json_encode(repetido($request->getAttribute("tabla"), $request->getAttribute("columna"), 
            $request->getAttribute("valor")));
    }else{
        echo json_encode(array("no_auth" => "No tienes permisos para usar este servicio"));
    }
});

// Una vez creado servicios los pongo a disposición
$app->run();
?>
