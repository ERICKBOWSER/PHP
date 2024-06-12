<?php

require __DIR__ . '/Slim/autoload.php';
require "src/funciones_servicios.php";

$app= new \Slim\App;

$app->post("/salir", function($request){
    session_id($request->getParam("api_session"));
    session_start();
    session_destroy();
    $respuesta["log_out"]="Cerrada sesión en la API.";
    echo json_encode($respuesta);
});

$app->post("/login", function($request){
    $usuario=$request->getParam("usuario");
    $clave=$request->getParam("clave");

    echo json_encode(login($usuario, $clave));
});

$app->post("/logueado", function($request){
    session_id($request->getParam("api_session"));
    session_start();
    if($_SESSION["usuario"]){

        $usuario=$_SESSION["usuario"];
        $clave=$_SESSION["clave"];

        json_encode(loguedo($usuario, $clave));
    }

});


// Una vez creado servicios los pongo a disposición
$app->run();
?>