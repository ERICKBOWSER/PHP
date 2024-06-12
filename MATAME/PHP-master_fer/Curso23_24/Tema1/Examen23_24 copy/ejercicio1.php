
<?php

    function generarFichero(){

        if(file_exists("claves_cesa.txt")){

            echo "<p>El archivo ya existe</p>";

        }else{
            
            @$fd=fopen("claves_cesa.txt","w");
            $primera_linea="Letra/Desplazamiento";
            for ($i=1; $i <=26 ; $i++) { 

                $primera_linea.=";".$i;

            }
            $cont_textarea=$primera_linea."\n";
            fwrite($fd,$primera_linea.PHP_EOL);

          
            for ($i=ord("A"); $i <=ord("Z"); $i++) { 

                $linea=chr($i);
                for ($j=1; $j <=ord("Z")-ord("A"); $j++) { 


                    if($i+$j<=ord("Z")){

                        $linea.=";".chr($i+$j);

                    }else{
        
                        $linea.=";".chr(ord("A")+($i+$j)-ord("Z")-1);
                    }
          
                }
                $cont_textarea=$linea."\n";
                fwrite($fd,$primera_linea.PHP_EOL);
            }
         
            fclose($fd);
        }

    }


    function leerFichero(){
        @$fd=fopen("claves_cesar.txt","r");
        $contenidoFichero = file_get_contents("claves_cesar.txt");
        echo "<textarea name='respuesta' id='respuesta'>".$contenidoFichero."</textarea>";
        echo "<p>Fichero generado con exito</p>";
        fclose($fd);
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
    <h1>Ejercicio1.Generador de "claves_cesar"</h1>
    <form action="ejercicio1.php" method="post">

        <p>
            <button name="generar" id="generar" type="submit">Generar</button>
        </p>

    </form>
</body>
</html>


<?php

    if(isset($_POST["generar"])){

        echo "<h1>Respuesta</h1>";
        generarFichero();
        leerFichero();
        
    
    }


?>
