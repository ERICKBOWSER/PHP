<?php

require __DIR__ . '/Slim/autoload.php';
require 'src/funciones_api.php';

$app= new \Slim\App;

$app->get('/saludo/{codigo}',function($request){

    //$datos["cod"]=$request->getParam('cod');
    echo json_encode(array("mensaje"=> "Hola ".$request->getAttribute('codigo')) ,JSON_FORCE_OBJECT);

});

// login, logueado y salir son imprescindibles para SEGURIDAD

$app->post('/login', function($request){
    $datos[] = $request->getParam('usuario');
    $datos[]=$request->getParam('clave');

    echo json_encode(login($datos));
});

$app->post('/logueado', function($request){ // SE USA PARA LA SEGURIDAD PARA SABER SI UN USUARIO ESTA LOGUEADO O BANEADO

    session_id($request->getParam('api_key'));// mandame la id de la session y abrimos sessión
    session_start();

    if(isset($_SESSION['usuario'])){
        $datos[]=$_SESSION['usuario'];
        $datos[]=$_SESSION['clave'];
        echo json_encode(logueado($datos));


    }else{
        session_destroy();
        $respuesta['no_auth']='No tienes permiso para usar este servicio';
        echo json_encode($respuesta);
    }
    
});

$app->post('/salir', function($request){
    session_id($request->getParam('api_key'));
    session_start();
    session_destroy();
    $respuesta['no_auth']="Sesión cerrada";

    echo json_encode($respuesta);
});

// Insertar usuario

$app->post('/insertar_usuario', function($request){
    $datos[]=$request->getParam('nombre');
    $datos[]=$request->getParam('usuario');
    $datos[]=$request->getParam('clave');
    $datos[]=$request->getParam('dni');
    $datos[]=$request->getParam('sexo');
    $datos[]=$request->getParam('subscripcion');

    echo json_encode(insertar_usuario($datos));

    // Un servicio no muere nunca
    
}); // ESTE PUNTO Y COMA ES IMPRESCINDIBLE, SE SUELE OLVIDAR

$app->put('/actualizar_foto/(id_usuario)', function($request){
    $datos[]=$request->getAtribute('id_usuario');
    $datos[]=$request->getParam('nombre_foto');

    echo json_encode(actualizar_foto($datos));
});

$app->get('/repetido_insert/{tabla}/{columna}/{valor}', function($request){
    $tabla=$request->getAtribute('tabla');
    $columna=$request->getAtribute('columna');
    $valor=$request->getAtribute('valor');

    echo json_encode(repetido_insertando($tabla, $columna, $valor));
});

$app->get('/repetido_edit/{tabla}/{columna}/{valor}/{columna_clave/{valor_clave}', function($request){
    
    session_id($request->getParam('api_key'));// mandame la id de la session y abrimos sessión
    session_start();

    if(isset($_SESSION['usuario']) && $_SESSION['tipo'] == 'admin'){
        $tabla=$request->getAtribute('tabla');
        $columna=$request->getAtribute('columna');
        $valor=$request->getAtribute('valor');
        $columna_clave=$request->getAtribute('columna_clave');
        $valor_clave=$request->getAtribute('valor_clave');
    
        echo json_encode(repetido_insertando($tabla, $columna, $valor, $columna_clave, $valor_clave));
    
    }else{
        session_destroy();
        $respuesta['no_auth']='No tienes permiso para usar este servicio';
        echo json_encode($respuesta);
    }
});

$app->get('/obtener_usuarios', function($request){

    session_id($request->getParam('api_key'));// mandame la id de la session y abrimos sessión
    session_start();

    if(isset($_SESSION['usuario']) && $_SESSION['tipo'] == 'admin'){
        echo json_encode(obtener_todos_usuarios());
    }else{
        session_destroy();
        $respuesta['no_auth']='No tienes permiso para usar este servicio';
        echo json_encode($respuesta);
    }
});

$app->get('/obtener_usuarios_pag/{pag}/{n_registros}', function($request){
    session_id($request->getParam('api_key'));// mandame la id de la session y abrimos sessión
    session_start();

    if(isset($_SESSION['usuario']) && $_SESSION['tipo'] == 'admin'){
        echo json_encode(obtener_usuarios_pag($request->getAtribute("pag"), $request->getAtribute('n_registros')));
    }else{
        session_destroy();
        $respuesta['no_auth']='No tienes permiso para usar este servicio';
        echo json_encode($respuesta);
    }
});

$app->get('/obtener_usuarios_filtro', function($request){
    session_id($request->getParam('api_key'));// mandame la id de la session y abrimos sessión
    session_start();

    if(isset($_SESSION['usuario']) && $_SESSION['tipo'] == 'admin'){
        echo json_encode(obtener_todos_usuarios_filtro($request->getAtribute("pag"), $request->getParam('buscar')));
    }else{
        session_destroy();
        $respuesta['no_auth']='No tienes permiso para usar este servicio';
        echo json_encode($respuesta);
    }
});

$app->get('/obtener_usuarios_filtro_pag/{pag}/{n_registros}', function($request){
    session_id($request->getParam('api_key'));// mandame la id de la session y abrimos sessión
    session_start();

    if(isset($_SESSION['usuario']) && $_SESSION['tipo'] == 'admin'){
        echo json_encode(obtener_usuarios_filtro_pag($request->getAtribute("pag"),$request->getParam('n_registro') , $request->getParam('buscar')));
    }else{
        session_destroy();
        $respuesta['no_auth']='No tienes permiso para usar este servicio';
        echo json_encode($respuesta);
    }
});

$app->get('/obtener_detalles/{id_usuario}', function($request){
    session_id($request->getParam('api_key'));// mandame la id de la session y abrimos sessión
    session_start();

    if(isset($_SESSION['usuario']) && $_SESSION['tipo'] == 'admin'){
        echo json_encode(obtener_detalles_usuario($request->getAtribute("id_usuario")));
    }else{
        session_destroy();
        $respuesta['no_auth']='No tienes permiso para usar este servicio';
        echo json_encode($respuesta);
    }
});

$app->get('/obtener_detalles/{id_usuario}', function($request){
    session_id($request->getParam('api_key'));// mandame la id de la session y abrimos sessión
    session_start();

    if(isset($_SESSION['usuario']) && $_SESSION['tipo'] == 'admin'){
        echo json_encode(obtener_detalles_usuario($request->getAtribute("id_usuario")));
    }else{
        session_destroy();
        $respuesta['no_auth']='No tienes permiso para usar este servicio';
        echo json_encode($respuesta);
    }
});

$app->put("/actualizar_usuario_clave", function($request){

    session_id($request->getParam('api_key'));// mandame la id de la session y abrimos sessión
    session_start();

    if(isset($_SESSION['usuario']) && $_SESSION['tipo'] == 'admin'){
        $datos[]=$request->getParam('nombre');
        $datos[]=$request->getParam('usuario');
        $datos[]=$request->getParam('clave');
        $datos[]=$request->getParam('dni');
        $datos[]=$request->getParam('sexo');
        $datos[]=$request->getParam('subscripcion');
        $datos[]=$request->getAtribute("id_usuario");
    
        echo json_encode(actualizar_usuario_clave($datos));    
    }else{
        session_destroy();
        $respuesta['no_auth']='No tienes permiso para usar este servicio';
        echo json_encode($respuesta);
    }
    
});

$app->put("/actualizar_usuario_sin_clave", function($request){

    session_id($request->getParam('api_key'));// mandame la id de la session y abrimos sessión
    session_start();

    if(isset($_SESSION['usuario']) && $_SESSION['tipo'] == 'admin'){
        $datos[]=$request->getParam('nombre');
        $datos[]=$request->getParam('usuario');
        $datos[]=$request->getParam('dni');
        $datos[]=$request->getParam('sexo');
        $datos[]=$request->getParam('subscripcion');
        $datos[]=$request->getAtribute("id_usuario");
    
        echo json_encode(actualizar_usuario_sin_clave($datos));  
    }else{
        session_destroy();
        $respuesta['no_auth']='No tienes permiso para usar este servicio';
        echo json_encode($respuesta);
    }
});


// Una vez creado servicios los pongo a disposición
$app->run();
?>