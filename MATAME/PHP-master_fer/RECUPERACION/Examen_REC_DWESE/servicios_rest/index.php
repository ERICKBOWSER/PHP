<?php

require "src/funciones_servicios.php";
require __DIR__ . '/Slim/autoload.php';

$app= new \Slim\App;


$app->post('/login',function($request){
    $usuario=$request->getParam("usuario");
    $clave=$request->getParam("clave");
    echo json_encode(login($usuario,$clave));
});

$app->get('/logueado',function($request){
    $token = $request->getParam("api_session");
    session_id($token);
    session_start();
    if(isset($_SESSION["usuario"])){
        echo json_encode(logueado($_SESSION["usuario"],$_SESSION["clave"]));
    }else{
        echo json_encode(array("no_auth"=>"No tienes permisos para usar este servicio"));
    }
});

$app->post('/salir',function($request){
    $api_session=$request->getParam("api_session");
    session_id($api_session);
    session_start();
    session_destroy();
    echo json_encode(array("log_out"=>"Cerrada sesión en la API"));
});

// pasa idUsu
$app->get('/usuario/{id_usuario}',function($request){
    $token = $request->getParam("api_session");
    session_id($token);
    session_start();

    if(isset($_SESSION["usuario"])){
        $idUsu = $request->getAttribute("id_usuario");
        echo json_encode(datosUsu($idUsu));
    }else{
        echo json_encode(array("no_auth"=>"No tienes permisos para usar este servicio"));
    }
});

// pasa dia y hora para tener a TODOS los usuarios
$app->get('/usuariosGuardia/{dia}/{hora}',function($request){
    $token = $request->getParam("api_session");
    session_id($token);
    session_start();

    if(isset($_SESSION["usuario"])){
        $dia = $request->getAttribute("dia");
        $hora = $request->getAttribute("hora");
        echo json_encode(horariosUsuarios($dia,$hora));
    }else{
        echo json_encode(array("no_auth"=>"No tienes permisos para usar este servicio"));
    }
});



// Una vez creado servicios los pongo a disposición
$app->run();
?>
