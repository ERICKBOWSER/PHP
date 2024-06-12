
<?php

    function generarFichero(){

        if(file_exists("claves_cesa.txt")){

            echo "<p>El archivo ya existe</p>";

        }else{
            
            @$fd=fopen("claves_cesa.txt","w");
            fputs($fd,"Letra/Desplazamiento");
            for ($i=0; $i <=26 ; $i++) { 
                fputs($fd,";".$i);
            }
    

            for ($j=0; $j <= 26; $j++) { 
                for ($i="A"; $i < "Z"; $i++) { 


                    fputs($fd,";".$i);
                }
            }
            
           
            
        
            fclose($fd);
        }

    }


    function leerFichero(){
        @$fd=fopen("claves_cesar.txt","r");
        $contenidoFichero = file_get_contents("claves_cesar.txt");
        echo "<textarea name='respuesta' id='respuesta' width='100' height='100'>".$contenidoFichero."</textarea>";
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
