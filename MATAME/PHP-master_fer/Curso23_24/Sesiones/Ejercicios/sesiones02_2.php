
<?php

session_name("sesiones02");
session_start();


if(isset($_POST["btnSig"]) || isset($_POST["btnBorrar"])){



    if(isset($_POST["btnBorrar"])){
        session_destroy();
       
    }else{
        if($_POST["nombre"]==""){
            $_SESSION["error"]="No has tecleado nada";
        }else{
            $_SESSION["nombre"]=$_POST["nombre"];
        }
    }
}
header("Location:sesiones02_1.php");
exit;

?>

