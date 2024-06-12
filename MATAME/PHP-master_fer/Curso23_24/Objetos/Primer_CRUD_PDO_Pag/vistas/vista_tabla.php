<?php

if(!isset($_SESSION["n_registros"]))
{
    $_SESSION["n_registros"]=3;
    $_SESSION["buscar"]="";
}

if(isset($_POST["n_registros"]))
{
    $_SESSION["n_registros"]=$_POST["n_registros"];
    $_SESSION["buscar"]=$_POST["buscar"];
    $_SESSION["pag"]=1;
}

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

?>   
<h2>Listado de los usuarios</h2>
<form id='regis_busc' action='index.php' method='post'>
    <div>
        <label for='n_registros'>Registros a mostrar: </label>
        <select name="n_registros" id="n_registros" onchange="document.getElementById('regis_busc').submit();">
            <option value="3" <?php if($_SESSION["n_registros"]=="3") echo "selected";?>>3</option>
            <option value="6" <?php if($_SESSION["n_registros"]=="6") echo "selected";?>>6</option>
            <option value="-1" <?php if($_SESSION["n_registros"]=="-1") echo "selected";?>>TODOS</option>
        </select>
    </div>
    <div>
        <input type="text" name="buscar" value="<?php echo $_SESSION["buscar"];?>"><button type="submit" name="btnBuscar">Buscar</button>
    </div>
</form>
<?php

try{
    if($_SESSION["buscar"]=="")
    {
        if($_SESSION["n_registros"]=="-1")
        {
            $consulta="select * from usuarios";
        }
        else
        {
            $inic_limit=($_SESSION["pag"]-1)*$_SESSION["n_registros"];
            $consulta="select * from usuarios limit ".$inic_limit.",".$_SESSION["n_registros"];
        }
    }
    else
    {
        if($_SESSION["n_registros"]=="-1")
        {
            $consulta="select * from usuarios where nombre LIKE '%".$_SESSION["buscar"]."%'";
        }
        else
        {
            $inic_limit=($_SESSION["pag"]-1)*$_SESSION["n_registros"];
            $consulta="select * from usuarios where nombre LIKE '%".$_SESSION["buscar"]."%' limit ".$inic_limit.",".$_SESSION["n_registros"];
        }
    }

    
    
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
    if($_SESSION["buscar"]=="")
    {
        $consulta="select * from usuarios";
    }
    else
    {
        $consulta="select * from usuarios where nombre LIKE '%".$_SESSION["buscar"]."%'";
    }
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

$n_paginas=ceil($sentencia->rowCount()/$_SESSION["n_registros"]);
$sentencia=null;
if($n_paginas>1)
{
    echo "<form id='paginas' action='index.php' method='post'>";
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