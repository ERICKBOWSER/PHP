<?php
require "src/funciones_ctes.php";
require __DIR__ . '/Slim/autoload.php';

$app = new \Slim\App;

$app->get('/productos', function(){
    echo json_encode(obtenerProductos());
});

$app->get('/producto/{cod}', function($request){
    echo json_encode(obtenerProductos($request -> getAttribute("cod")));
});

$app->post('/producto/insertar', function($request){
    $datos[]= $request -> getParam("cod");
    $datos[]= $request -> getParam("nombre");
    $datos[]= $request -> getParam("nombre_corto");
    $datos[]= $request -> getParam("descripcion");
    $datos[]= $request -> getParam("PVP");
    $datos[]= $request -> getParam("familia");

    echo json_encode(insertarProducto($datos));
    
});

$app->put('/producto/actualizar/{cod}', function($request){
    
    $datos[]= $request -> getParam("nombre");
    $datos[]= $request -> getParam("nombre_corto");
    $datos[]= $request -> getParam("descripcion");
    $datos[]= $request -> getParam("PVP");
    $datos[]= $request -> getParam("familia");
    $datos[]= $request -> getParam("cod");

    echo json_encode(actualizarProducto($datos));
});

$app->delete("/producto/borrar/{cod}", function($request){
    echo json_encode(borrarProducto($request->getAttribute("cod")));
});

$app->get('/familias', function(){
    echo json_encode(obtenerFamilias());
});

$app->get('/repetido/{tabla}/columna/{valor}', function($request){
    echo json_encode(repetido($request->getAttribute('tabla'), $request->getAttribute('columna'), $request->getAttribute($valor)));
});

$app->get('/repetido/{tabla}/columna/{valor}/{columna_id}/{valor_id}', function($request){
    echo json_encode(repetidoEditar($request->getAttribute('tabla'), $request->getAttribute('columna'), $request->getAttribute($valor)));
});

$app -> run();

?>