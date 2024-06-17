<?php

require "src/funciones_servicios.php";
require __DIR__ . '/Slim/autoload.php';

$app= new \Slim\App;




$app->get('/login',function($request){
    
     $usuario=$request->getParam("usuario");
    $clave=$request->getParam("clave");
  

    echo json_encode(login($usuario,$clave));
});

$app->get('/logueado', function ($request) {

    session_id($request->getParam("api_session"));
    session_start();
 
    if (isset($_SESSION["usuario"])) {
       $usuario = $_SESSION["usuario"];
       $clave = $_SESSION["clave"];
       echo json_encode(logueado($usuario, $clave));
    } else {
 
       session_destroy();
       $respuesta["no_auth"] = "No tienes permiso para usar este servicio";
       echo json_encode($respuesta);
    }
 });

 $app->get('/profesor/{id_usuario}', function ($request) {

   session_id($request->getParam("api_session"));
   session_start();
   $usuario=$request->getAttribute("id_usuario");

   if (isset($_SESSION["usuario"])) {
   
      
      echo json_encode(horariosProfesor($usuario));
   }
});

$app->get('/todosGrupos', function ($request) {

   session_id($request->getParam("api_session"));
   session_start();


   if (isset($_SESSION["usuario"]) &&  $_SESSION["tipo"]=="admin") {
   
      
      echo json_encode(todosGrupos());
   }
   else {
 
      session_destroy();
      $respuesta["no_auth"] = "No tienes permiso para usar este servicio";
      echo json_encode($respuesta);
   }
});



$app->get('/horarioGrupo/{id_grupo}', function ($request) {

   session_id($request->getParam("api_session"));
   session_start();
   $id_grupo=$request->getAttribute("id_grupo");

   if (isset($_SESSION["usuario"]) &&  $_SESSION["tipo"]=="admin") {
   
      
      echo json_encode(horarioGrupo($id_grupo));
   }
   else {
 
      session_destroy();
      $respuesta["no_auth"] = "No tienes permiso para usar este servicio";
      echo json_encode($respuesta);
   }
});

$app->get('/profesoresLibres/{dia}/{hora}/{id_grupo}', function ($request) {

   session_id($request->getParam("api_session"));
   session_start();
   $dia=$request->getAttribute("dia");
   $hora=$request->getAttribute("hora");
   $id_grupo=$request->getAttribute("id_grupo");

   if (isset($_SESSION["usuario"]) &&  $_SESSION["tipo"]=="admin") {
   
      
      echo json_encode(profesoresLibres($dia,$hora,$id_grupo));
   }
   else {
 
      session_destroy();
      $respuesta["no_auth"] = "No tienes permiso para usar este servicio";
      echo json_encode($respuesta);
   }
});

$app->get('/profesoresOcupados/{dia}/{hora}/{id_grupo}', function ($request) {

   session_id($request->getParam("api_session"));
   session_start();
   $dia=$request->getAttribute("dia");
   $hora=$request->getAttribute("hora");
   $id_grupo=$request->getAttribute("id_grupo");

   if (isset($_SESSION["usuario"]) &&  $_SESSION["tipo"]=="admin") {
   
      
      echo json_encode(profesoresOcupados($dia,$hora,$id_grupo));
   }
   else {
 
      session_destroy();
      $respuesta["no_auth"] = "No tienes permiso para usar este servicio";
      echo json_encode($respuesta);
   }
});

$app->delete('/borrarProfesor/{dia}/{hora}/{id_grupo}/{id_usuario}', function ($request) {

   session_id($request->getParam("api_session"));
   session_start();
   $dia=$request->getAttribute("dia");
   $hora=$request->getAttribute("hora");
   $id_grupo=$request->getAttribute("id_grupo");
   $usuario=$request->getAttribute("id_usuario");

   if (isset($_SESSION["usuario"]) &&  $_SESSION["tipo"]=="admin") {
   
      
      echo json_encode(borrarProfesor($dia,$hora,$id_grupo,$usuario));
   }
   else {
 
      session_destroy();
      $respuesta["no_auth"] = "No tienes permiso para usar este servicio";
      echo json_encode($respuesta);
   }
});

// Una vez creado servicios los pongo a disposición
$app->run();
?>
