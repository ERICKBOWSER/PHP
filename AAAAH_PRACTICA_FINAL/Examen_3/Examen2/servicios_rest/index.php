<?php

require "src/funciones_servicios.php";
require __DIR__ . '/Slim/autoload.php';

$app= new \Slim\App;



$app->get('/conexion_PDO',function($request){

    echo json_encode(conexion_pdo());
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

$app->post('/salir', function($request){
    $token= $request->getParam("api_session");
});



// Una vez creado servicios los pongo a disposición
$app->run();
?>
