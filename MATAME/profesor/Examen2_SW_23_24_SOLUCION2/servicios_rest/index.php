<?php

require "src/funciones_servicios.php";
require __DIR__ . '/Slim/autoload.php';

$app= new \Slim\App;


$app->post('/salir',function($request){
    session_id($request->getParam("api_session"));
    session_start();
    session_destroy();
    $respuesta["log_out"]="Cerrada sesión en la API";
    echo json_encode($respuesta);
});


$app->post('/login',function($request){
    $user=$request->getParam("usuario");
    $pass=$request->getParam("clave");

    echo json_encode(login($user,$pass));

});

$app->get('/logueado',function($request){

    session_id($request->getParam("api_session"));
    session_start();
    if(isset($_SESSION["user"]))
    {
        $user=$_SESSION["user"];
        $pass=$_SESSION["pass"];
        echo json_encode(logueado($user,$pass));
    }
    else
    {
        session_destroy();
        $respuesta["no_auth"]="No tienes permisos para usar este servicio";
        echo json_encode($respuesta);
    }

});

$app->get('/obtenerProfesores',function($request){

    session_id($request->getParam("api_session"));
    session_start();
    if(isset($_SESSION["user"]))
    {
      
        echo json_encode(obtener_profesores());
    }
    else
    {
        session_destroy();
        $respuesta["no_auth"]="No tienes permisos para usar este servicio";
        echo json_encode($respuesta);
    }

});

$app->get('/obtenerHorario/{cod_prof}',function($request){

    session_id($request->getParam("api_session"));
    session_start();
    if(isset($_SESSION["user"]))
    {
      
        echo json_encode(obtener_horario($request->getAttribute("cod_prof")));
    }
    else
    {
        session_destroy();
        $respuesta["no_auth"]="No tienes permisos para usar este servicio";
        echo json_encode($respuesta);
    }

});

$app->get('/gruposHorario/{dia}/{hora}/{cod_prof}',function($request){

    session_id($request->getParam("api_session"));
    session_start();
    if(isset($_SESSION["user"]))
    {
      
        echo json_encode(obtener_grupos_horario($request->getAttribute("dia"),$request->getAttribute("hora"),$request->getAttribute("cod_prof")));
    }
    else
    {
        session_destroy();
        $respuesta["no_auth"]="No tienes permisos para usar este servicio";
        echo json_encode($respuesta);
    }

});

$app->get('/gruposNoHorario/{dia}/{hora}/{cod_prof}',function($request){

    session_id($request->getParam("api_session"));
    session_start();
    if(isset($_SESSION["user"]))
    {
      
        echo json_encode(obtener_grupos_no_horario($request->getAttribute("dia"),$request->getAttribute("hora"),$request->getAttribute("cod_prof")));
    }
    else
    {
        session_destroy();
        $respuesta["no_auth"]="No tienes permisos para usar este servicio";
        echo json_encode($respuesta);
    }

});

$app->post('/agregarGrupo/{dia}/{hora}/{cod_prof}/{id_grupo}',function($request){

    session_id($request->getParam("api_session"));
    session_start();
    if(isset($_SESSION["user"]))
    {
      
        echo json_encode(agregar_grupo($request->getAttribute("dia"),$request->getAttribute("hora"),$request->getAttribute("cod_prof"),$request->getAttribute("id_grupo")));
    }
    else
    {
        session_destroy();
        $respuesta["no_auth"]="No tienes permisos para usar este servicio";
        echo json_encode($respuesta);
    }

});


$app->delete('/borrarGrupo/{id_horario}',function($request){

    session_id($request->getParam("api_session"));
    session_start();
    if(isset($_SESSION["user"]))
    {
      
        echo json_encode(borrar_grupo($request->getAttribute("id_horario")));
    }
    else
    {
        session_destroy();
        $respuesta["no_auth"]="No tienes permisos para usar este servicio";
        echo json_encode($respuesta);
    }

});

// Una vez creado servicios los pongo a disposición
$app->run();
?>
