<?php
echo "<div class='centrar centrado'>";
echo "<form method='post' action='index.php'>";
echo "<input type='hidden' name='foto' value='".$_POST["foto"]."'/>";
echo "<h2>Borrado del usuario con id: ".$_POST["btnBorrar"]."</h2>";
echo "<p>¿ Estás seguro ?</p>";
echo "<p><button type='submit' name='btnContBorrar' value='".$_POST["btnBorrar"]."'>Sí</button> <button type='submit'>No</button></p>";
echo "</form>";
echo "</div>";
?>