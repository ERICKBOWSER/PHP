<?php

require "src/funciones_servicios.php";
require __DIR__ . '/Slim/autoload.php';

$app = new \Slim\App;


$app->post("/login", function($request){

    $usuario = $request->getParam("usuario");
    $clave = $request->getParam("clave");


    echo json_encode(login($usuario,$clave));

});

$app->post("/salir", function($request){

    $api_session = $request->getParam("api_session");
    session_id($api_session);
    session_start();
    session_destroy();
    $respuesta["log_out"]="Cerrando sesion en la api";
    echo json_encode($respuesta);

});
$app->get('/logueado', function ($request) {

    $api_session = $request->getParam("api_session");
    session_id($api_session);
    session_start();
    if (isset($_SESSION["usuario"])) {

        echo json_encode(logueado($_SESSION["usuario"], $_SESSION["clave"]));
    } else {

        session_destroy();
        $respuesta["no_auth"] = "No tienes permiso para usar este servicio";
        echo json_encode($respuesta);
    }
});





// Una vez creado servicios los pongo a disposición
$app->run();
