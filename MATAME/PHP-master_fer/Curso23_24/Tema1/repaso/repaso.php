<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=ç, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <?php

        $longitud=strlen($string1); //Longitud de un string (Tambien cuenta los espacios)

        $a=$string1[3]; //Accede a la posicion del string es decir como string es "Hola" accederia a las 3 que es la letra "a"

        $sep_arr=explode(" ",$prueba); //CONVIERTE EN UN ARRAY EL STRING  //EL PRIMER VALOR ES EL DELIMITADOR DE SEPARACION , EL SEGUNDO ES EL STRING
        
        echo "<p>".substr("hola que tal, Juan",14,4)."</p>"; //EN LA PRIMERA SE PONE EN LA CADENA , DESPUES EN QUE POSICION SE VA A PONER Y DESPUES A PARTIR DE AHI LOS CARACTERES QUE TE VA A DAR
    
        for ($i=1; $i <= 10 ; $i++) { 
            fputs($fd,$i." x ".$_POST["num"]." = ".($i*$_POST["num"]).PHP_EOL);
        }    
    
     //PARA COGER 1 LINEA
     $linea=fgets($fd1);
     echo "<p>".$linea."</p>";
    //SI LO ESCRIBO OTRA VEZ SE PASA A LA SEGUNDA LINEA Y ASI SUCESIVAMENTE
    
    

        //CREAR UN FICHERO 
        
        if(isset($_POST["btnEnviar"]) && !$error_form){

            $nombre_fichero="tabla_".$_POST["num"].".txt";
           
            if(!file_exists("Tablas/".$nombre_fichero,"w")){
                
                @$fd=fopen("Tablas/".$nombre_fichero,"w");
                if(!$fd){
                    die("<p>No se ha podido crear el fichero 'Tablas/".$nombre_fichero."'</p>");
                }
                for ($i=1; $i <= 10 ; $i++) { 
                    fputs($fd,$i." x ".$_POST["num"]." = ".($i*$_POST["num"]).PHP_EOL);
                }
    
                fclose($fd);
            }
            echo "<p>Fichero generado con exito</p>";   
        }

        <input type="file" name="archivo" id="archivo" accept="image/*"> //importante

        //errores fichero if(isset($_POST["Contar"])){

            //OBLIGATORIO
        $error_formu = $_FILES["fichero"]["name"] == "" || $_FILES["fichero"]["error"] || $_FILES["fichero"]["type"] != "text/plain" || $_FILES["fichero"]["size"]> 2500*1024 ;
        //NO OBLIGATORIO
        $error_archivo=$_FILES["archivo"]["name"]!="" && ($_FILES["archivo"]["error"] || !getimagesize($_FILES["archivo"]["tmp_name"]) || $_FILES["archivo"]["size"] > 500*1024); 
        //ERRORES
        if(isset($_POST["Contar"]) && $error_formu) {

            if($_FILES["fichero"]["name"] ==""){

                echo "<span class='error'>*</span>";

            }elseif($_FILES["fichero"]["error"]){

                echo "<span class='error'>Error: no se ha podido subir el fichero al servidor</span>";

            }elseif($_FILES["fichero"]["type"] !="text/plain"){

                echo "<span class='error'>Error: no has seleccionado un fichero .txt</span>";

            }else{

                echo "<span class='error'>Error: el tamaño del fichero supera los 2.5MB</span>";
            }
        }


        echo "<p>".date("d/m/y")."</p>"; //DIA/MES/AÑO

        if(checkdate(2,28,2023)){ //DEVUELVE TRUE O FALSE POR checkdate(2,29,2023) esta devolveria false es decir fecha mala porque el 29 de febrero ese año no estaba

            echo "<p>Fecha Buena</p>";
        }else{
            echo "<p>Fecha Mala</p>";
        }

    

        //DNI GUCHI
        function LetraNIF($dni){
            return substr("TRWAGMYFPDXBNJZSQVHLCKEO", $dni % 23,1);
        }
        
        function dni_bien_escrito($texto){
        
            return strlen($texto)==9 && is_numeric(substr($texto,0,8)) && substr($texto,-1)>="A" && substr($texto,-1)<="Z";
        
        }
        
        function dni_valido($texto){
        
            $numero = substr($texto,0,8);
            $letra = substr($texto,-1);
            $valido = LetraNIF($numero) == $letra;
            // return LetraNIF(substr($texto,0,8))==substr($texto,-1);
            return $valido;
        }

        //juntar 2 arrays
        $lenguajes=array_merge($lenguajes_cliente,$lenguajes_servidor);
        //dale la vuelta a un array 
        $reversa=array_reverse($arr4);


        
        $familias = array (
            "Los Simpsons"=>array("Padre" => "Homer","Madre" => "Marge","Hijos"=>array("Hijo1" => "Bart","Hijo2" => "Lisa","Hijo3" => "Maggie")),
            "Los Griffin"=>array("Padre" => "Peter","Madre" => "Lois","Hijos"=>array("Hijo1"=>"Chris","Hijo2"=>"Meg","Hijo3"=>"Stewie"))
        ); 



        echo "<ul>";
        foreach ($familias as $indice => $profesion) {
            echo "<li>";
            echo $indice;
            echo "<ul>";
                foreach ($profesion as $indice2 => $nombres) {
                    echo "<li>";
                    echo $indice2.": ";
                    if(is_array($nombres)){
                        echo "<ul>";
                        foreach ($nombres as $indice3 => $valor) {
                            echo "<li>";
                            echo $indice3.": ";
                            echo $valor;
                            echo "</li>";
                        }
                        echo "</ul>";
                    }else {
                        echo $nombres;
                    }
                    echo "</li>";
                }
            echo "</ul>";
            echo "</li>";
        }
        echo "</ul>";
    ?>

    
</body>
</html>