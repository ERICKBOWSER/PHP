<?php

echo'<h1>Nuevo Usuario</h1>';
echo'<form action="usuario_nuevo.php" method="post" enctype="multipart/form-data">';
        echo'<p>';
            echo'<label for="nombre">Nombre:</label>';
            echo'<input type="text" name="nombre" id="nombre" maxlength="30" value="<?php if(isset($_POST["nombre"])) echo $_POST["nombre"] ?>">';
            
        echo'</p>';

        echo'<p>';
        echo'<label for="usuario">Usuario:</label>';
        echo'<input type="text" name="usuario" id="usuario" maxlength="20" value="<?php if(isset($_POST["usuario"])) echo $_POST["usuario"] ?>">';
        
        echo'</p>';

        echo'<p>';
        echo'<label for="email">Email:</label>';
        echo'<input type="text" name="email" id="email" maxlength="50" value="<?php if(isset($_POST["email"])) echo $_POST["email"] ?>">';
            
        echo'</p>';

        echo'<p>';
            echo'<button type="submit" name="continuar">Continuar</button>';
            echo'<button type="submit" name="volver">Volver</button>';
        echo'</p>';
    echo'</form>';
?>