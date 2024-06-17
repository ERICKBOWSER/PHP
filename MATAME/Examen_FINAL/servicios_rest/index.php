<?php

require "src/funciones_servicios.php";
require __DIR__ . '/Slim/autoload.php';

$app= new \Slim\App;

$app->post('/salir', function($request){
    session_id($request->getParam("api_session"));
    session_start();
    session_destroy();
    $respuesta["log_out"]="Sesión cerrada.";
    echo json_encode($respuesta);
});

$app->post('/login', function($request){
    $user=$request->getParam("usuario");
    $pass=$request->getParam("clave");

    echo json_encode(login($user, $pass));
});

$app->get('/logueado', function($request){
    session_id($request->getParam("api_session"));
    session_start();

    if(isset($_SESSION["user"])){
        $user = $_SESSION["user"];
        $pass = $_SESSION["pass"];

        echo json_encode(logueado($user, $pass));
    }else{
        session_destroy();
        $respuesta["no_auth"]="No tienes permisos para usar este servicio";
        echo json_encode($respuesta);
    }
});

$app->get('/horarioProfesor/{id_usuario}', function($request){
    session_id($request->getParam("api_session"));
    session_start();
    if(isset($_SESSION["user"])){
        echo json_encode(obtener_horario_profesor($request->getAttribute("id_usuario")));
    }else{
        session_destroy();
        $respuesta["no_auth"]="No tienes permisos para usar este servicio";
        echo json_encode($respuesta);
    }
});

$app->get('/horarioGrupo/{id_grupo}', function($request){
    session_id($request->getParam("api_session"));
    session_start();
    if(isset($_SESSION["user"])){
        echo json_encode(obtener_horario_grupo($request->getAttribute("id_grupo")));
    }else{
        session_destroy();
        $respuesta["no_auth"]="No tienes permisos para usar este servicio";
        echo json_encode($respuesta);
    }
});

$app->get('/grupos', function($request){
    session_id($request->getParam("api_session"));
    session_start();
    if(isset($_SESSION["user"])){
        echo json_encode(obtener_grupos());
    }else{
        session_destroy();
        $respuesta["no_auth"]="No tienes permisos para usar este servicio";
        echo json_encode($respuesta);
    }
});


$app->run();