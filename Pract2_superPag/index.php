<?php
function enArray($valor, $arr){
    $esta = false;

    for($i = 0; $i < count($arr); $i++){
        if($arr($i) == $valor){
            $esta = true;
            break;
        }
    }

    return $esta;
}


// Comprobar errores
if(isset($_POST["submit"])){
    $error_nombre = $_POST["nombre"] == "";
    $error_sexo = $_POST["sexo"] == "";
    $error_form = $error_nombre || $error_sexo;

}
if(isset($_POST["submit"]) && !$error_form){
    echo "repsuesta";

}else{
    require "vistas/vista_formulario.php";
}


?>
