<?php

require __DIR__ . '/Slim/autoload.php';

$app= new \Slim\App;


require "src/funciones_api.php";


$app->post("/salir",function($request){

    session_id($request->getParam("api_key"));
    session_start();
    session_destroy();
    $respuesta["logout"]="Sesión cerrada";
    echo json_encode($respuesta);
});

$app->post("/login",function($request){

    $datos[]=$request->getParam("usuario");
    $datos[]=$request->getParam("clave");
    echo json_encode(login($datos));
});

$app->post("/logueado",function($request){

    session_id($request->getParam("api_key"));
    session_start();
    if(isset($_SESSION["usuario"]))
    {
        $datos[]=$_SESSION["usuario"];
        $datos[]=$_SESSION["clave"];
        echo json_encode(logueado($datos));
    }
    else
    {
        session_destroy();
        $respuesta["no_auth"]="No tienes permiso para usar este servicio";
        echo json_encode($respuesta);
    }
    
});

$app->post("/insertar_usuario",function($request){

        $datos[]=$request->getParam("nombre");
        $datos[]=$request->getParam("usuario");
        $datos[]=$request->getParam("clave");
        $datos[]=$request->getParam("dni");
        $datos[]=$request->getParam("sexo");
        $datos[]=$request->getParam("subscripcion");

        echo json_encode(insertar_usuario($datos));
  
});


$app->put("/actualizar_foto",function($request){

    $datos[]=$request->getParam("nombre_foto");
    $datos[]=$request->getParam("id_usuario");
    

    echo json_encode(actualizar_foto($datos));
});

$app->get("/repetido_insert/{tabla}/{columna}/{valor}",function($request){

    $tabla=$request->getAttribute("tabla");
    $columna=$request->getAttribute("columna");
    $valor=$request->getAttribute("valor");
    echo json_encode(repetido_insertando($tabla,$columna,$valor));

});

$app->get("/repetido_edit/{tabla}/{columna}/{valor}/{columna_clave}/{valor_clave}",function($request){
    session_id($request->getParam("api_key"));
    session_start();
    if(isset($_SESSION["usuario"]) && $_SESSION["tipo"]=="admin")
    {
        $tabla=$request->getAttribute("tabla");
        $columna=$request->getAttribute("columna");
        $valor=$request->getAttribute("valor");
        $columna_clave=$request->getAttribute("columna_clave");
        $valor_clave=$request->getAttribute("valor_clave");
        echo json_encode(repetido_editando($tabla,$columna,$valor,$columna_clave,$valor_clave));
    }
    else
    {
        session_destroy();
        $respuesta["no_auth"]="No tienes permiso para usar este servicio";
        echo json_encode($respuesta);
    }

});


$app->get("/obtener_usuarios",function($request){

    session_id($request->getParam("api_key"));
    session_start();
    if(isset($_SESSION["usuario"]) && $_SESSION["tipo"]=="admin")
    {
        echo json_encode(obtener_todos_usuarios());
    }
    else
    {
        session_destroy();
        $respuesta["no_auth"]="No tienes permiso para usar este servicio";
        echo json_encode($respuesta);
    }

});

$app->get("/obtener_usuarios_pag/{pag}/{n_registros}",function($request){
    session_id($request->getParam("api_key"));
    session_start();
    if(isset($_SESSION["usuario"]) && $_SESSION["tipo"]=="admin")
    {
        echo json_encode(obtener_usuarios_pag($request->getAttribute("pag"),$request->getAttribute("n_registros")));
    }
    else
    {
        session_destroy();
        $respuesta["no_auth"]="No tienes permiso para usar este servicio";
        echo json_encode($respuesta);
    }
});

$app->get("/obtener_usuarios_filtro",function($request){
    session_id($request->getParam("api_key"));
    session_start();
    if(isset($_SESSION["usuario"]) && $_SESSION["tipo"]=="admin")
    {
        echo json_encode(obtener_todos_usuarios_filtro($request->getParam("buscar")));
    }
    else
    {
        session_destroy();
        $respuesta["no_auth"]="No tienes permiso para usar este servicio";
        echo json_encode($respuesta);
    }

});

$app->get("/obtener_usuarios_filtro_pag/{pag}/{n_registros}",function($request){
    session_id($request->getParam("api_key"));
    session_start();
    if(isset($_SESSION["usuario"]) && $_SESSION["tipo"]=="admin")
    {
        echo json_encode(obtener_usuarios_filtro_pag($request->getAttribute("pag"),$request->getAttribute("n_registros"),$request->getParam("buscar")));
    }
    else
    {
        session_destroy();
        $respuesta["no_auth"]="No tienes permiso para usar este servicio";
        echo json_encode($respuesta);
    }
});

$app->get("/obtener_detalles/{id_usuario}",function($request){
    session_id($request->getParam("api_key"));
    session_start();
    if(isset($_SESSION["usuario"]) && $_SESSION["tipo"]=="admin")
    {
        echo json_encode(obtener_detalles_usuario($request->getAttribute("id_usuario")));
    }
    else
    {
        session_destroy();
        $respuesta["no_auth"]="No tienes permiso para usar este servicio";
        echo json_encode($respuesta);
    }
});

$app->delete("/borrar_usuario/{id_usuario}",function($request){
    session_id($request->getParam("api_key"));
    session_start();
    if(isset($_SESSION["usuario"]) && $_SESSION["tipo"]=="admin")
    {
        echo json_encode(borrar_usuario($request->getAttribute("id_usuario")));
    }
    else
    {
        session_destroy();
        $respuesta["no_auth"]="No tienes permiso para usar este servicio";
        echo json_encode($respuesta);
    }
});

$app->put("/actualizar_usuario_con_clave/{id_usuario}",function($request){
    session_id($request->getParam("api_key"));
    session_start();
    if(isset($_SESSION["usuario"]) && $_SESSION["tipo"]=="admin")
    {
        $datos[]=$request->getParam("nombre");
        $datos[]=$request->getParam("usuario");
        $datos[]=$request->getParam("clave");
        $datos[]=$request->getParam("dni");
        $datos[]=$request->getParam("sexo");
        $datos[]=$request->getParam("subscripcion");
        $datos[]=$request->getAttribute("id_usuario");

        echo json_encode(actualizar_usuario_clave($datos));
    }
    else
    {
        session_destroy();
        $respuesta["no_auth"]="No tienes permiso para usar este servicio";
        echo json_encode($respuesta);
    }
});

$app->put("/actualizar_usuario_sin_clave/{id_usuario}",function($request){
    session_id($request->getParam("api_key"));
    session_start();
    if(isset($_SESSION["usuario"]) && $_SESSION["tipo"]=="admin")
    {
        $datos[]=$request->getParam("nombre");
        $datos[]=$request->getParam("usuario");
        $datos[]=$request->getParam("dni");
        $datos[]=$request->getParam("sexo");
        $datos[]=$request->getParam("subscripcion");
        $datos[]=$request->getAttribute("id_usuario");

        echo json_encode(actualizar_usuario_sin_clave($datos));
    }
    else
    {
        session_destroy();
        $respuesta["no_auth"]="No tienes permiso para usar este servicio";
        echo json_encode($respuesta);
    }
});

$app->run();

?>