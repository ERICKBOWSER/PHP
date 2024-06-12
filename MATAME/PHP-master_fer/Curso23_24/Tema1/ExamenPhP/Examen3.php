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
    <form action="Examen3.php" method="post">
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
            echo "<p>El texto contiene: ".count(mi_explode($_POST["sep"],$_POST["texto"]))." palabras separados por: ".$_POST["sep"]."</p";
        }

    ?>

</body>
</html>