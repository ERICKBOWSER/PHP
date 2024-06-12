<?php
session_name("contador");
session_start();
if(!isset($_SESSION["contador"])){ 

    $_SESSION["contador"]=0;

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>SUBIR Y BAJAR NUMERO</h1>
    <form action="sesiones032.php" method="post">
        <p>Haga click en los botones para modificar el valor</p>
        <p><button type="submit" name="btnContador" value="menos">-</button> 
        <?php echo $_SESSION["contador"]?> 
        <button type="submit"  name="btnContador" value="mas">+</button></p>
        <p><button type="submit"  name="btnContador" value="cero">Poner a cero</button></p>
    </form>

</body>

</html>