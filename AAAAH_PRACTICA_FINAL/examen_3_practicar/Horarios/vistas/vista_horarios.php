<?php
$url = DIR_SERV . "/obtenerHorarios";
$respuesta = consumir_servicios_REST($url, "GET");
$obj = json_decode($respuesta);

if(!$obj){
    session_destroy();
    die("<p>Error consumiendo el servicio: " . $url . "</p></body></html>");
}

if(isset($obj->error)){
    session_destroy();
    die("<p>" . $obj->error . "</p></body></html>");
}

echo "<h2>Su horario</h2>";
echo "<p>Horario del Profesor: ";

foreach($obj->usuarios as $user){
    echo $user->usuario;
}

foreach($obj->horario_lectivo as $horario){
    echo $horario;
    echo $horario-> $grupo;

}