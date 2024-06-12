<?php

echo "<p>Se dispone usted a borrar al usuario <strong>" . $_POST["nombre_usuario"] . "</strong></p>";
echo "<form action='index.php' method='post'>";
echo "<p><button type='submit' name='btnContBorrar' value='" . $_POST["btnBorrar"] . "'>Continuar</button> ";
echo "<button type='submit'>Atras</button></p>";
echo "</form>";
?>