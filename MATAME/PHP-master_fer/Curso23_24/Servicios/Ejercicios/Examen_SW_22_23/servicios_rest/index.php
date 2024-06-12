<?php

require "src/funciones_servicios.php";
require __DIR__ . '/Slim/autoload.php';

$app= new \Slim\App;



$app->post('/login',function($request){

    $lector=$request->getParam("lector");
    $clave=$request->getParam("clave");
    
    echo json_encode(login($lector,$clave));
});


$app->get('/logueado',function($request){

    $token=$request->getParam("api_session");
    session_id($token);
    session_start();
    if(isset($_SESSION["usuario"]))
    {
        echo json_encode(logueado($_SESSION["usuario"],$_SESSION["clave"]));
    }
    else
    {
        session_destroy();
        echo json_encode(array("no_auth"=>"No tienes permisos para usar este servicio"));
    }
});

$app->get('/profesores',function($request){

    echo json_encode(obtener_profesores());


});






$app->post('/salir',function($request){

    $token=$request->getParam("api_session");
    session_id($token);
    session_start();
    session_destroy();
    echo json_encode(array("log_out"=>"Cerrada sesión en la API"));
});


$app->get('/obtenerLibros',function(){


    echo json_encode(obtener_libros());
 
});

$app->post('/crearLibro',function($request){

    $token=$request->getParam("api_session");
    session_id($token);
    if(isset($_SESSION["usuario"]) && $_SESSION["tipo"]=="admin")
    {
        $datos[]=$request->getParam("referencia");
        $datos[]=$request->getParam("titulo");
        $datos[]=$request->getParam("autor");
        $datos[]=$request->getParam("descripcion");
        $datos[]=$request->getParam("precio");

        echo json_encode(insertar_libro($datos));
    }
    else
    {
        session_destroy();
        echo json_encode(array("no_auth"=>"No tienes permisos para usar este servicio"));
    }
 
});

$app->put('/actualizarPortada/{referencia}',function($request){

    $token=$request->getParam("api_session");
    session_id($token);
    if(isset($_SESSION["usuario"]) && $_SESSION["tipo"]=="admin")
    {
        $datos[]=$request->getParam("portada");
        $datos[]=$request->getAttribute("referencia");
        
        echo json_encode(actualizar_portada($datos));
    }
    else
    {
        session_destroy();
        echo json_encode(array("no_auth"=>"No tienes permisos para usar este servicio"));
    }
 
});

$app->get('/repetido/{tabla}/{columna}/{valor}',function($request){

    $token=$request->getParam("api_session");
    session_id($token);
    if(isset($_SESSION["usuario"]) && $_SESSION["tipo"]=="admin")
    {
        
        echo json_encode(repetido($request->getAttribute("tabla"),$request->getAttribute("columna"),$request->getAttribute("valor")));
    }
    else
    {
        session_destroy();
        echo json_encode(array("no_auth"=>"No tienes permisos para usar este servicio"));
    }
 
});
// Una vez creado servicios los pongo a disposición
$app->run();
?>
