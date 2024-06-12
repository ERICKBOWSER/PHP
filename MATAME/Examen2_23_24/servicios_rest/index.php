<?php

require __DIR__ . '/Slim/autoload.php';
require "src/funciones_servicios.php";

$app= new \Slim\App;

$app->post("/salir", function($request){
    session_id($request->getParam("api_session"));
    session_start();
    session_destroy();
    $respuesta["log_out"]="Cerrada sesión en la API";
    echo json_encode($respuesta);
});

$app->post("/login", function($request){
    $usuario=$request->getParam("usuario");
    $clave=$request->getParam("clave");
    
    echo json_encode(login($usuario, $clave));
});

$app->get("/logueado", function($request){
    session_id($request->getParam("api_session"));
    session_start();
    if(isset($_SESSION["usuario"])){
        $usuario=$_SESSION["usuario"];
        $clave=$_SESSION["clave"];
        echo json_encode(logueado($usuario, $clave));
    }else{
        session_destroy();
        $respuesta["no_auth"]="No tienes permisos para usar este servicio desde /logueado";
        echo json_encode($respuesta);
    }
});

$app->get("/obtenerProfesores", function($request){
    session_id($request->getParam("api_session"));
    session_start();
    if($_SESSION["usuario"]){
        echo json_encode(obtener_profesores());
    }else{
        session_destroy();
        $respuesta["no_auth"]="No tienes permisos para usar este servicio desde /obtenerProfesores";
        echo json_encode($respuesta);
    }
});

$app->get("/obtenerHorario/{id_usuario}", function($request){
    session_id($request->getParam("api_session"));
    session_start();
    // HEMOS QUITADO $_SESSION["USUARIO"] PORQUE DABA FALLOS
    echo json_encode(obtenerHorario($request->getAttribute("id_usuario")));

});

$app->get("/obtenerHorarioDiaHora/{id_usuario}",function($request){
    session_id($request->getParam("api_session"));
    session_start();
        $datos[]=$request->getAttribute("id_usuario");
        $datos[]=$request->getParam("dia");
        $datos[]=$request->getParam("hora");
        echo json_encode(obtener_horario_dia_hora($datos));
});

$app->get("/obtenerHorarioNoDiaHora/{id_usuario}",function($request){
    session_id($request->getParam("api_session"));
    session_start();
        $datos[]=$request->getAttribute("id_usuario");
        $datos[]=$request->getParam("dia");
        $datos[]=$request->getParam("hora");
        echo json_encode(obtener_horario_no_dia_hora($datos));
});

$app->post("/insertarGrupo", function($request){
    session_id($request->getParam("api_session"));
    session_start();

        $datos[]=$request->getParam("usuario");
        $datos[]=$request->getParam("dia");
        $datos[]=$request->getParam("hora");
        $datos[]=$request->getParam("grupo");
        echo json_encode(insertar_grupo($datos));

});

$app->delete("/borrarGrupo/{id_horario}", function($request){
    session_id($request->getParam("api_session"));
    session_start();
        echo json_encode(borrar_grupo($request->getAttribute("id_horario")));
});


// Una vez creado servicios los pongo a disposición
$app->run();
?>