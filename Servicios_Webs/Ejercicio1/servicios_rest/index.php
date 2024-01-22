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