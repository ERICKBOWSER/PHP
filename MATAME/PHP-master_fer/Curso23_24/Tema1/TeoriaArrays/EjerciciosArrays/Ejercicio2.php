<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio2</title>
</head>
<body>
    <?php

        $v[1]=90;
        $v[30]=7;
        $v['e']=99;
        $v['hola']=43;

        foreach ($v as $orden => $valor) {


            if(is_numeric($orden)){

                echo "<p>En la posicion: <b>".$orden."</b> esta el: <b>".$valor."</b></p>";

            }else{

                echo "<p>En la posicion: <b>'".$orden."'</b> esta el: <b>".$valor."</b></p>";

            }
            
          

        }


    ?>
</body>
</html>