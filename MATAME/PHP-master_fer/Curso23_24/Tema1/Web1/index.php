<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Teoria elemental de php dia: <?php echo date ("d-m-Y"); ?></h1>
    <?php
                echo "<h1>Mi primera pagina Curso 23-24</h1>";
                $a=8;
                $b=9;
                $c=$b+$a;
                echo "<p>El resultado de sumar: " .$a. " + " .$b. " es: " .$c. "</p>";

                define("PI",3.1415); //Definir una constante

                if(3>$c && $c>1) // || es para decir esto o esto , ! esto es negacion 
                {
                    echo "<p>3 es mayor que " .$c. "</p>";
                }
                elseif(3==$c)
                {
                    echo "<p>3 es igual que " .$c. "</p>";
                }
                else 
                {
                    echo "<p>3 es menor que " .$c. "</p>";
                }

                $d=4;
                switch($d){

                    case 1: $c=$a-$b; break;
                    case 2: $c=$a/$b; break;
                    case 3: $c=$a*$PI; break;

                    default: $c=$a+$b; break;
                }

                echo "<p> EL resultado del switch es: " .$c. "</p>";

                for($i=0;$i<=8;$i++)
                {
                    echo "<p>Hola ".($i+1)." </p>";
                }

                $i=0;
                while ($i<=8) {
                    echo "<p> Hola " .($i+1)." </p>";
                    $i++;
                }


  
    ?>


</body>
</html>