<?php
 $url=DIR_SERV."/obtenerLibros";
 $respuesta=consumir_servicios_REST($url,"GET");
 $obj=json_decode($respuesta);
 if(!$obj)
 {
     session_destroy();
     die("<p>Error consumiendo el servicio: ".$url."</p></body></html>");
 }
 if(isset($obj->error))
 {
     session_destroy();
     die("<p>".$obj->error."</p></body></html>");
 }

 echo "<h2>Listado de los libros</h2>";
 echo "<div id='libros'>";
 foreach($obj->libros as $tupla)
 {
     echo "<div>";
     echo "<img src='images/".$tupla->portada."' alt='portada' title='portada'><br>".$tupla->titulo." - ".$tupla->precio." €";
     echo "</div>";
 }
 echo "</div>";
?>