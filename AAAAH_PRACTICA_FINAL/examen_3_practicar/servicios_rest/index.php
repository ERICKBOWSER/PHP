<?php

require "src/funciones_servicios.php";
require __DIR__ . '/Slim/autoload.php';

$app= new \Slim\App;



$app->get('/conexion_PDO',function($request){

    echo json_encode(conexion_pdo());
});

$app->get('/conexion_MYSQLI',function($request){
    
    echo json_encode(conexion_mysqli());
});

$app->get('/obtenerHorarios', function(){
    echo json_encode(obtener_horarios());
});

// Una vez creado servicios los pongo a disposición
$app->run();
?>
