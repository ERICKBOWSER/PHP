<?php

$n_reg_mostrar=3;

if(!isset($_SESSION["pag"]))
{
    $_SESSION["pag"]=1;
}

if(isset($_POST["btnPagina"]))
{
    $_SESSION["pag"]=$_POST["btnPagina"];
}

/////////
if(!isset($conexion))
{
    try
    {
        $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    }
    catch(PDOException $e)
    {
        session_destroy();
        die("<p>No ha podido conectarse a la base de batos: ".$e->getMessage()."</p></body></html>");
    }
}


try{
    $inic_limit=($_SESSION["pag"]-1)*$n_reg_mostrar;
    $consulta="select * from usuarios limit ".$inic_limit.",".$n_reg_mostrar;
    $sentencia=$conexion->prepare($consulta);
    $sentencia->execute();
}
catch(PDOException $e)
{
    $sentencia=null;
    $conexion=null;
    session_destroy();
    die("<p>No se ha podido realizar la consulta: ".$e->getMessage()."</p></body></html>");
}

$resultado=$sentencia->fetchAll(PDO::FETCH_ASSOC);
$sentencia=null;
    
echo "<h2>Listado de los usuarios</h2>";
echo "<table>";
echo "<tr><th>Nombre de Usuario</th><th>Borrar</th><th>Editar</th></tr>";
foreach($resultado as $tupla)
{
    echo "<tr>";
    echo "<td><form action='index.php' method='post'><button class='enlace' type='submit' value='".$tupla["id_usuario"]."' name='btnDetalle' title='Detalles del Usuario'>".$tupla["nombre"]."</button></form></td>";
    echo "<td><form action='index.php' method='post'><input type='hidden' name='nombre_usuario' value='".$tupla["nombre"]."'><button class='enlace' type='submit' value='".$tupla["id_usuario"]."' name='btnBorrar'><img src='images/borrar.png' alt='Imagen de Borrar' title='Borrar Usuario'></button></form></td>";
    echo "<td><form action='index.php' method='post'><button class='enlace' type='submit' value='".$tupla["id_usuario"]."' name='btnEditar'><img src='images/editar.png' alt='Imagen de Editar' title='Editar Usuario'></button></form></td>";
    echo "</tr>";
}
echo "</table>";

try{
   
    $consulta="select * from usuarios";
    $sentencia=$conexion->prepare($consulta);
    $sentencia->execute();
}
catch(PDOException $e)
{
    $sentencia=null;
    $conexion=null;
    session_destroy();
    die("<p>No se ha podido realizar la consulta: ".$e->getMessage()."</p></body></html>");
}

$n_paginas=ceil($sentencia->rowCount()/$n_reg_mostrar);
$sentencia=null;
if($n_paginas>1)
{
    echo "<form action='index.php' method='post'>";
    echo "<p>";
    if($_SESSION["pag"]!=1)
    {
        echo "<button type='submit' name='btnPagina' value='1'>|<<</button>";
        echo "<button type='submit' name='btnPagina' value='".($_SESSION["pag"]-1)."'><</button>";
    }

    for($i=1;$i<=$n_paginas;$i++)
    {
        if($i==$_SESSION["pag"])
            echo "<button disabled type='submit' name='btnPagina' value='".$i."'>".$i."</button>";
        else
            echo "<button type='submit' name='btnPagina' value='".$i."'>".$i."</button>";
    }

    if($_SESSION["pag"]!=$n_paginas)
    {
        echo "<button type='submit' name='btnPagina' value='".($_SESSION["pag"]+1)."'>></button>";
        echo "<button type='submit' name='btnPagina' value='".$n_paginas."'>>>|</button>";
    }

    echo "</p>";
    echo "</form>";
}


if(isset($_SESSION["mensaje"]))
{
    echo "<p class='mensaje'>".$_SESSION["mensaje"]."</p>";
    session_destroy();
    //unset($_SESSION["mensaje"]);
}



?>