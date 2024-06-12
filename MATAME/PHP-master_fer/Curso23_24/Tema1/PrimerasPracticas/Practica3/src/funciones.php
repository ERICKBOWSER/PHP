<?php
 function LetraNIF($dni){
    return substr("TRWAGMYFPDXBNJZSQVHLCKEO", $dni % 23,1);
}

function dni_bien_escrito($texto){

    return strlen($texto)==9 && is_numeric(substr($texto,0,8)) && substr($texto,-1)>="A" && substr($texto,-1)<="Z";

}

function dni_valido($texto){

    $numero = substr($texto,0,8);
    $letra = substr($texto,-1);
    $valido = LetraNIF($numero) == $letra;
    // return LetraNIF(substr($texto,0,8))==substr($texto,-1);
    return $valido;
}
?>