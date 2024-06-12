<?php

    if(isset($_POST["contar"])){

        $error_formu=$_POST["texto"] =="";
    }

    function mi_explode($sep,$texto){

        $aux=[];
        $l_texto=strlen($texto);

        $i=0;
        while ($i<$l_texto && $texto[$i]==$sep) {

            $i++;
        }

            if($i<$l_texto){
                
                $j=0;
                $aux[$j]=$texto[$i];

                for ($i=$i+1;$i<$l_texto;$i++) { 

                    if($texto[$i]!=$sep){

                        $aux[$j].=$texto[$i]; //.= para concatenar

                    }else{

                        while ($i<$l_texto && $texto[$i]==$sep) {

                            $i++;
                        }
                        if($i<$l_texto){

                            $j++;
                            $aux[$j]=$texto[$i];
                        }
                    }

                    }
        
                }

                return $aux;
    }


    function tiene_vocales($texto){

        $vocales["a"]=1;
        $vocales["A"]=1;
        $vocales["e"]=1;
        $vocales["E"]=1;
        $vocales["i"]=1;
        $vocales["I"]=1;
        $vocales["o"]=1;
        $vocales["O"]=1;
        $vocales["u"]=1;
        $vocales["U"]=1;

        $tiene=false;
        for ($i=0; $i <strlen($texto); $i++) { 

            if($texto[$i] == $vocales){

                return false;

            }else{
                return true;
            }
            
        }
    }
    function filtrar_sin_vocales($arr_palabras){

        $respuesta=[];
        for ($i=0; $i < count($arr_palabras); $i++) { 
            
            if(!tiene_vocales($arr_palabras[$i])){
                $respuesta[]=$arr_palabras[$i];
            }
        }
        return $respuesta;

    }

        
    
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .error{color:red;}
    </style>
</head>
<body>
    <form action="ejercicio2.php" method="post">
    <p>
        <label for="sep">Elija Separador</label>
        <select name="sep" id="sep">
            <option <?php  if(isset($_POST["contar"]) && $_POST["sep"] == ",") echo "selected"; ?> value=",">, (coma)</option>
            <option <?php  if(isset($_POST["contar"]) && $_POST["sep"] == ";") echo "selected"; ?> value=";">; (punto y coma)</option>
            <option <?php  if(isset($_POST["contar"]) && $_POST["sep"] == " ") echo "selected"; ?> value=" "> (espacio)</option>
            <option <?php  if(isset($_POST["contar"]) && $_POST["sep"] == ":") echo "selected"; ?> value=":">: (dos puntos)</option>
        </select>
    </p>

    <p>
        <label for="texto">Introduzca una frase</label>
        <input type="text" name="texto" id="texto" value="<?php if(isset($_POST["texto"])) echo $_POST["texto"];?>">
        <?php

            if(isset($_POST["contar"]) && $error_formu){
                echo "<span class='error'>*Escribe un texto por favor*</span>";
            }
        ?>
    </p>

    <p>
        <button type="submit" name="contar">Contar</button>
    </p>


    <?php
        if(isset($_POST["contar"]) && !$error_formu){
            echo "<h2>Respuesta</h2>";
            $palabras_por_separador=mi_explode($_POST["sep"],$_POST["texto"]);
            $palabras_sin_vocales=filtrar_sin_vocales($palabras_por_separador);
            echo "<p>El texto contiene: ".count($palabras_sin_vocales)." palabras separados por: ".$_POST["sep"]."</p";
        }

    ?>

</body>
</html>