<?php

require "src/funciones_servicios.php";
require __DIR__ . "/Slim/autoload.php";

$app = new \Slim\App;

$app->post("/login", function($request){
    $usuario=$request->getParam("usuario");
    $clave=$request->getParam("clave");

    echo json_encode(login($usuario, $clave)); // Para devolver la representación JSON del valor
});

$app->get("/logueado", function($request){
    $api_session=$request->getParam("api_session"); // ¿Que trae?
    session_id($api_session);
    session_start();

    if(isset($_SESSION['usuario'])){
        echo json_encode(logueado($_SESSION["usuario", $_SESSION["clave"]]));
    }else{
        session_destroy();
        echo json_encode(array("no_auth"=>"No tienes permisos para usar este servicio LOGUEADO"));
    }
});

$app->post("/salir", function($request){
    $api_session=$request->getParam("api_session");
    session_id($api_session);
    session_start();
    session_destroy();
    echo json_encode(array("log_out"=>"Cerrada sesión en la API SALIR"));
});

$app->get("/alumnos", function($request){
    $api_session=$request->getParam("api_session");
    session_id($api_session);
    session_start();
    if(isset($_SESSION["usuario"]) && $_SESSION["tipo"]=="tutor"){
        echo json_encode(obtener_alumnos());
    }else{
        session_destroy();
        echo json_encode(array("no_auth" => "No tienes permisos para usar este tipo de servicio"));
    }
});

// OBTENER NOTAS DEL ALUMNO
$app->get("/notasAlumno/{cod_alu}", function($request){
 $api_session=$request->getParam("api_session");
 session_id($api_session);
 session_start();
 if(isset($_SESSION["usuario"])){
    echo json_encode(obtener_notas_alumno($request->getAttribute("cod_alu"))); // LA REQUEST ENTIENDO QUE ES PARA OBTENER EL DATO DE LA URL QUE ES POR DONDE SE PARA EL cod_alu
 }else{
    session_destroy();
    echo json_encode(array("no_auth"=> "No tienes permisos para usar este servicio en el servicio NOTASALUMNO"));
 }
});

// NOTAS NO EVALUADAS ALUMNOS
$app->get("/NotasNoEvalAlumno/{cod_alu}", function($request){
    $api_session=$request->getParam("api_session");
    session_id($api_session);
    session_start();
    // EL USUARIO TIENE QUE SER TIPO tutor YA QUE ES EL QUE TIENE LOS PERMISOS PARA ACCEDER A LOS DATOS DE LOS ALUMNOS
    if(isset($_SESSION["usuario"]) && $_SESSION["tipo"]=="tutor"){
        echo json_encode(obtener_notas_no_eval_alumno($request->getAttribute("cod_alu")));
    }else{
        session_destroy();
        echo json_encode(array("no_auth"=>"No tienes permisos para usar este servicio"));
    }
});

// QUITAR NOTA
$app->delete("/quitarNota/{cod_alu}", function($request){
    $api_session=$request->getParam("api_session");
    session_id($api_session);
    session_start();
    if(isset($_SESSION["usuario"]) && $_SESSION["tipo"]=="tutor"){
        // El ARRAY ES PORQUE PASAMOS VARIOS DATOS LUEGO A LA FUNCIÓN
        $datos[]=$request->getParam("cod_asig");
        $datos[]=$request->getAttribute("cod_alu");
        echo json_encode(quitar_nota($datos));
    }else{
        session_destroy();
        echo json_encode(array("no_auth"=>"No tienes permisos para usar este servicio desde el servicio QUITARNOTA"));
    }
});

// CAMBIAR NOTA
$app->put("/cambiarNota/{cod_alu}", function($request){
    $api_session=$request->getParam("api_session");
    session_id($api_session);
    session_start();
    if(isset($_SESSION["usuario"]) && $_SESSION["tipo"] == "tutor"){
        $datos[]=$request->getParam("nota");
        $datos[]=$request->getParam("cod_asig");
        $datos[]=$request->getAttribute("cod_alu");
        echo json_encode(cambiar_nota($datos));
    }else{
        session_destroy();
        echo json_encode(array("no_auth"=>"No tienes permisos para usar este servicio desde CAMBIARNOTA"));
    }
});

$app->post("/ponerNota/{cod_alu}", function($request){
    $api_session=$request->getParam("api_session");
    session_id($api_session);
    session_start();
    if(isset($_SESSION["usuario"]) && $_SESSION["tipo"]=="tutor"){
        $datos[]=$request->getParam("cod_asig");
        $datos[]=$request->getAttribute("cod_alu");
        echo json_encode(poner_nota($datos));
    }else{
        session_destroy();
        echo json_encode(array("no_auth"=>"No tienes permisos para usar este servicio desde PONERNOTA"));
    }
});

// UNA VEZ CREADOS LOS SERVICIOS LOS PONEMOS A DISPOSICIÓN
$app->run();






































?>