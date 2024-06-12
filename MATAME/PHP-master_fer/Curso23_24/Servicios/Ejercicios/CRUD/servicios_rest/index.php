<?php

require __DIR__ . '/Slim/autoload.php';

$app = new \Slim\App;

require "src/funciones_ctes.php";
/*$app->get('/saludo',function(){

    $respuesta["mensaje"]="Hola";
    echo json_encode($respuesta);
});

$app->get('/saludo/{nombre}',function($request){

    $valor_recibido=$request->getAttribute('nombre');
    $respuesta["mensaje"]="Hola ".$valor_recibido;
    echo json_encode($respuesta);
});

$app->post('/saludo',function($request){

    $valor_recibido=$request->getParam('nombre');
    $respuesta["mensaje"]="Hola ".$valor_recibido;
    echo json_encode($respuesta);
});

$app->delete('/borrar_saludo/{id}',function($request){

    $id_recibida=$request->getAttribute('id');
    $respuesta["mensaje"]="Se ha borrado el saludo con id:".$id_recibida;
    echo json_encode($respuesta);
});

$app->put('/actualizar_saludo/{id}',function($request){

    $id_recibida=$request->getAttribute('id');
    $nombre_nuevo=$request->getParam('nombre');
    $respuesta["mensaje"]="Se ha actualizado el saludo con id:".$id_recibida." al nombre: ".$nombre_nuevo;
    echo json_encode($respuesta);
});
*/


//PARTE A
$app->get('/productos', function () {

    echo json_encode(obtener_productos());
});


//PARTE B
$app->get('/producto/{cod}', function ($request) {

    echo json_encode(obtener_producto($request->getAttribute('cod')));
});


//PARTE C

/*http://localhost/..../servicios_rest/producto/insertar
Insertaremos los productos que le pasaremos por un formulario retornando la infor-
mación:“El producto (nombre_corto) se ha insertado correctamente”*/

$app->post('/producto/insertar', function ($request) {

    $datos[] = $request->getParam("cod");
    $datos[] = $request->getParam("nombre");
    $datos[] = $request->getParam("nombre_corto");
    $datos[] = $request->getParam("descripcion");
    $datos[] = $request->getParam("PVP");
    $datos[] = $request->getParam("familia");

    echo json_encode(insertar_producto($datos));
});

$app->put('/producto/actualizar/{cod}', function ($request) {


    $datos[] = $request->getParam("nombre");
    $datos[] = $request->getParam("nombre_corto");
    $datos[] = $request->getParam("descripcion");
    $datos[] = $request->getParam("PVP");
    $datos[] = $request->getParam("familia");
    $datos[] = $request->getAttribute("cod");

    echo json_encode(actualizar_producto($datos));
});


$app->delete('/producto/borrar/{cod}', function ($request) {

    echo json_encode(borrar_producto($request->getAttribute("cod")));
});


$app->get('/familias', function () {

    echo json_encode(obtener_familia());
});


$app->get('/repetido/{tabla}/{columna}/{valor}', function ($request) {

    echo json_encode(repetido_insertar($request->getAttribute('tabla'),$request->getAttribute('columna'),$request->getAttribute('valor')));
});


$app->get('/repetido/{tabla}/{columna}/{valor}/{columna_id}/{valor_id}', function ($request) {

    echo json_encode(repetido_editar($request->getAttribute('tabla'),$request->getAttribute('columna'),$request->getAttribute('valor'),$request->getAttribute('columna_id'),$request->getAttribute('valor_id')));
});



$app->run();
