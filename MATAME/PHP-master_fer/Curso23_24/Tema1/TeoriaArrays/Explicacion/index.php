<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TeoriaArray</title>
</head>
<body>

    <?php

    //Array 
    /*
        $nota[0]=5;
        $nota[1]=9;
        $nota[2]=8;
        $nota[3]=5;
        $nota[4]=6;
        $nota[5]=7;


        $nota[]=5;
        $nota[]=9;
        $nota[]=8;
        $nota[]=5;
        $nota[]=6;
        $nota[]=7;
    */

    //Otra forma de definir un array
    $nota=array(5,9,8,5,6,7);


    //RECORRO EL ARRAY 
    echo "<h1>Recorrido de un array escalar con sus indices correlativos</h1>";
    for ($i=0; $i < count($nota); $i++) { 
        
        echo "<p>En la posicion: ".$i." tiene el valor: ".$nota[$i]."</p>";

    }

    print_r($nota); //el print_r solo funciona con arrays

    echo "<br>";

    var_dump($nota);   //el var_dump te funciona con todo

    //Se pueden meter distintos datos en un mismo array
    /*$valor[0]=18;
    $valor[0]="Hola";
    $valor[0]=true;
    $valor[0]=3.4;*/


    /*$valor[]=18;
    $valor[99]="Hola";
    $valor[]=true;
    $valor[200]=3.4;*/


    $valor=array(18,99=>"Hola",false,200=>3.4);

    //EL FOR EACH SE UTILIZA CUANDO NO TIENE LAS POSICIONES DEFINIDAS O NO TODAS DEFINIDAS PARA RECORRER EL ARRAY
    echo "<h1>Recorrido de un array escalar con sus indices NO correlativos</h1>";

    /*
        foreach($valor as $contenido){

            echo "<p>contenido: ".$contenido."</p>";

        }
    */

    //SI QUIERO QUE SALGAN LOS INDICES ES DECIR LAS POSICIONES
    foreach($valor as $indice => $contenido){

        echo "<p>En la posicion: ".$indice." tiene el valor: ".$contenido."</p>";

    }


    /*$notas["Antonio"]=5;
    $notas["Luis"]=9;
    $notas["Ana"]=8;
    $notas["Eloy"]=5;
    $notas["Gabriella"]=6;
    $notas["Berta"]=7;


    echo "<h1>Notas de DWESE</h1>";

    foreach($notas as $nombre => $nota){

        echo "<p>".$nombre." ha sacado un ".$nota."</p>";

    }*/

 
    //RECORRER UN ARRAY DENTRO DE OTRO

    $notas["Antonio"]["DWESE"]=5;
    $notas["Antonio"]["DWEC"]=7;
    $notas["Luis"]["DWESE"]=9;
    $notas["Luis"]["DWEC"]=7;
    $notas["Ana"]["DWESE"]=8;
    $notas["Ana"]["DWEC"]=9;
    $notas["Eloy"]["DWESE"]=5;
    $notas["Eloy"]["DWEC"]=6;

    echo "<h1>Notas de los Alumnos</h1>";

    foreach($notas as $nombre => $asignaturas){


        echo "<p>".$nombre."<ul>";

        foreach($asignaturas as $nombreAsignaturas => $nota){

            echo "<li><b>".$nombreAsignaturas."</b>: ".$nota."</li>";

        }



        echo "</ul></p>";

    }



    $capital=array("Castilla y León"=>"Valladolidad","Asturias"=>"Oviedo","Aragón"=>"Zaragoza");

    echo "<p>Ultimo valor de un array: ".current($capital)."</p>";

    echo "<p>Ultimo valor de un array: ".key($capital)."</p>";

    /*echo "<p>Ultimo valor de un array: ".end($capital)."</p>";*/
    end($capital);//PARA IRME AL FINAL

    echo "<p>Ultimo valor de un array: ".current($capital)."</p>";

    echo "<p>Ultimo valor de un array: ".key($capital)."</p>";

    reset($capital); //PARA IRME AL PRINCIPIO DEL ARRAY
    
    next($capital);//ME VOY UNO HACIA DELANTE 

    echo "<p>Ultimo valor de un array: ".current($capital)."</p>";

    echo "<p>Ultimo valor de un array: ".key($capital)."</p>";

    reset($capital);
    prev($capital); //ME VOY AL ANTERIOR

    echo "<p>Ultimo valor de un array: ".current($capital)."</p>";

    echo "<p>Ultimo valor de un array: ".key($capital)."</p>";

    reset($capital);

    while (current($capital)) {
        echo "<strong>".current($capital)."</strong><br/>";
        next($capital);
    }

    ?>
    
</body>
</html>