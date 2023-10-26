<?php
function mi_strlen($texto)
{
    $cont=0;
    while(isset($texto[$cont]))
        $cont++;

    return $cont;
}

function mi_explode($sep,$texto)
{
    $aux=[];
    $l_texto=mi_strlen($texto);
    $i=0;
    while($i<$l_texto && $texto[$i]==$sep)
        $i++;

    
    if($i<$l_texto)
    {
        $j=0;
        $aux[$j]=$texto[$i];
        for($i=$i+1;$i<$l_texto;$i++)
        {
            if($texto[$i]!=$sep)
            {
                $aux[$j].=$texto[$i];
            }
            else
            {

                while($i<$l_texto && $texto[$i]==$sep)
                    $i++;
                
                if($i<$l_texto)
                {
                    $j++;
                    $aux[$j]=$texto[$i];
                }
                
            }
        }


    }
    
    return $aux;
}


if(isset($_POST["btnContar"]))
{
    $error_form=$_POST["texto"]=="";
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio3 Exam Anterior</title>
    <style>
        .error{color:red}
    </style>
</head>
<body>
    <h1>Ejercicio 3</h1>
    <form action="ejercicio3.php" method="post">
        <p>
            <label for="sep">Elija Separador: </label>
            <select name="sep" id="sep">
                <option <?php if(isset($_POST["btnContar"]) && $_POST["sep"]==",") echo "selected";?> value=",">, (coma)</option>
                <option <?php if(isset($_POST["btnContar"]) && $_POST["sep"]==";") echo "selected";?> value=";">; (punto y coma)</option>
                <option <?php if(isset($_POST["btnContar"]) && $_POST["sep"]==" ") echo "selected";?> value=" "> (espacio)</option>
                <option <?php if(isset($_POST["btnContar"]) && $_POST["sep"]==":") echo "selected";?> value=":">: (dos puntos)</option>
            </select>
        </p>
        <p>
            <label for="texto">Introduzca una frase: </label>
            <input type="text" name="texto" id="texto" value="<?php if(isset($_POST["texto"])) echo $_POST["texto"];?>">
            <?php
            if(isset($_POST["btnContar"]) && $error_form)
                echo "<span class='error'>Campo vacío</span>";
            ?>
        </p>
        <p>
            <button type="submit" name="btnContar">Contar</button>
        </p>
    </form>
    <?php
    if(isset($_POST["btnContar"]) && !$error_form)
    {
        echo "<h2>Respuesta</h2>";
        echo "<p>El número de palabras del texto introducido separadas por el separador seleccionado es de :".count(mi_explode($_POST["sep"],$_POST["texto"]))."</p>";
    }
    ?>
</body>
</html>