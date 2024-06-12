<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio12</title>
</head>
<body>

    <?php

        $arr1=array('Lagartija','Araña','Perro','Gato','Raton');
        $arr2=array(12,34,45,52,12);
        $arr3=array('Sauce','Pino','Naranjo','Chopo','Perro',34);

        $arr4=array();
        array_push($arr4,$arr1,$arr2,$arr3);

        print_r($arr4);
    ?>
    
</body>
</html>