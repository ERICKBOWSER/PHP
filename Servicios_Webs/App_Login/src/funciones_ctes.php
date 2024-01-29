<?php
 define("MINUTOS", 5);
 define("DIR_SERV", "http://localhost/Proyectos/PHP/Servicios_Webs/ejercicio3/servicios_rest");
 
 function consumir_servicios_REST($url,$metodo,$datos=null)
     {
         $llamada=curl_init();
         curl_setopt($llamada,CURLOPT_URL,$url);
         curl_setopt($llamada,CURLOPT_RETURNTRANSFER,true);
         curl_setopt($llamada,CURLOPT_CUSTOMREQUEST,$metodo);
         if(isset($datos))
             curl_setopt($llamada,CURLOPT_POSTFIELDS,http_build_query($datos));
         $respuesta=curl_exec($llamada);
         curl_close($llamada);
         return $respuesta;
     }

 function errorPage($title, $body){
     $respuesta = '
     <!DOCTYPE html>
     <html lang="en">
     <head>
         <meta charset="UTF-8">
         <meta name="viewport" content="width=device-width, initial-scale=1.0">
         <title>' . $title . '</title>
     </head>
     <body>
         ' . $body . '
     </body>
     </html>';

     return $respuesta;
 }

?>