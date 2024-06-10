<?php
echo "<h2>Listado de los usuarios (no admin)</h2>";
?>
<div class='centrar centrado'>
<form id='form_regs_filtro' class="d_flex" action='index.php' method='post'>
    <div>
        Mostrar
        <select name='registros' onchange='document.getElementById("form_regs_filtro").submit();'>
            <option <?php if($_SESSION["regs_mostrar"]==3) echo "selected";?> value='3'>3</option>
            <option <?php if($_SESSION["regs_mostrar"]==6) echo "selected";?> value='6'>6</option>
            <option <?php if($_SESSION["regs_mostrar"]==-1) echo "selected";?> value='-1'>TODOS</option>
        </select>
        registros por página
    </div>
    <div>
        <input type="text" name="buscar" value="<?php echo $_SESSION["buscar"];?>"><button type="submit" name="btnBuscar">Buscar</button>
    </div>
</form>
</div>
<?php
echo "<table class='centrar centrado'>";
echo "<tr><th>#</th><th>Foto</th><th>Nombre</th><th><form action='index.php' method='post'><button class='enlace' type='submit' name='btnNuevo'>Usuario+</button></form></th></tr>";
foreach($usuarios as $tupla)
{
    echo "<tr>";
    echo "<td>".$tupla["id_usuario"]."</td>";
    echo "<td><img class='reducida' src='images/".$tupla["foto"]."' alt='Foto' title='Foto'></td>";
    echo "<td><form action='index.php' method='post'><button class='enlace' type='submit' value='".$tupla["id_usuario"]."' name='btnDetalles'>".$tupla["nombre"]."</button></form></td>";
    echo "<td><form action='index.php' method='post'><input type='hidden' name='foto' value='".$tupla["foto"]."'/><button class='enlace' type='submit' name='btnBorrar' value='".$tupla["id_usuario"]."'>Borrar</button> - <button class='enlace' type='submit' name='btnEditar' value='".$tupla["id_usuario"]."'>Editar</button></form></td>";
    echo "</tr>";
}
echo "</table>";

if($n_pags>1)
{
    echo "<div class='centrar centrado'>";
    echo "<form action='index.php' method='post'>";
    echo "<p>";
    if($_SESSION["pag"]!=1)
    {
        echo "<button  type='submit' name='btnPag' value='1'>|<</button> ";
        echo "<button  type='submit' name='btnPag' value='".($_SESSION["pag"]-1)."'><</button> ";
    }
    
    for($i=1;$i<=$n_pags;$i++)
    {
        if($_SESSION["pag"]==$i)
            echo "<button disabled type='submit' name='btnPag' value='".$i."'>".$i."</button> ";
        else
            echo "<button  type='submit' name='btnPag' value='".$i."'>".$i."</button> ";
    }
    if($_SESSION["pag"]!=$n_pags)
    {
        echo "<button  type='submit' name='btnPag' value='".($_SESSION["pag"]+1)."'>></button> ";
        echo "<button  type='submit' name='btnPag' value='".$n_pags."'>>|</button> ";
    }

    echo "</p>";
    echo "</form>";
    echo "</div>";
}


?>