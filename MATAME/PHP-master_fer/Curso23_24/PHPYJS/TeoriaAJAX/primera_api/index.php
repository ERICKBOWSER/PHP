<?php

require __DIR__ . '/Slim/autoload.php';

$app= new \Slim\App;


$app->get('/saludo',function(){

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


$app->run();

?>