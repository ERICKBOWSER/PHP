<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio5</title>
    <style>

        table,td,th{border:1px solid black;}
        table{border-collapse:collapse; width:90%; margin:0 auto;}

    </style>
</head>
<body>
        <?php
            @$fd1=fopen("http://dwese.icarosproject.com/PHP/datos_ficheros.txt","r");

            if(!$fd1){

                die("<h3>No se ha podido abrir el fichero: http://dwese.icarosproject.com/PHP/datos_ficheros.txt");

            }else{

                $linea=fgets($fd1);
                $datos_linea=explode("\t",$linea);
                $numero_colum=count($datos_linea);

                echo "<table>";
                echo "<caption><b>PIB DE LOS PAISES POR CAPITALES</b></caption>";

                    echo "<tr>";

                        for ($i=0; $i <$numero_colum; $i++) { 

                            echo "<th>".$datos_linea[$i]."</th>";
                        }
                    
                    echo "</tr>";


                    while($linea=fgets($fd1)) {

                        $datos_linea=explode("\t",$linea);
                        echo "<tr>";

                        echo "<th>".$datos_linea[0]."</th>";

                        for ($i=1; $i < $numero_colum; $i++) { 
                            
                            if(isset($datos_linea[$i])){

                                echo "<td>".$datos_linea[$i]."</td>";

                            }else{
                                echo "<td></td>";

                            }

                        }
                        

                        echo "</tr>";
                    }
                echo "</table>";
                fclose($fd1);

            }



        ?>
</body>
</html>