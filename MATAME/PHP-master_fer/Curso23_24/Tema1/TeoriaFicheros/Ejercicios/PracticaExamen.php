<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PracticaExamen</title>
</head>
<body>
    
    <form action="PracticaExamen.php" method="post" enctype="multipart/form-data">

        <label> Introduza una palabra para comprobar si se repite algun caracter o no</label>
        <p>
            <input type="text" name="texto" id="texto" value="">
        </p>

        <p>
            <button type="submit" name="Comprobar">Comprobar</button>
        </p>

        <?php

            $texto=$_POST["texto"];
            $contador=0;
            $contador2=0;
    
            for ($j=0; $j < strlen($texto); $j++) { 

                $letrarep = $texto[$j];
                $contador=0;

                for ($i=0; $i < strlen($texto); $i++) { 

                    if($texto[$i] == $letrarep){
                        $contador++;
                        if($contador > $contador2){
                            $contador2 = $contador;
                         
                        }
                    }
                  
                }

            }
            if($contador2>1
            ){
                echo "<p>Hay uno o varios caracteres repetidos</p>";
            }else{
                echo "<p>No hay caracteres repetidos</p>";
            }
            

          
        ?>
    
    </form>
</body>
</html>