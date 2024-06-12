$(document).ready(function(){

    function cargar_vista_borrar(error)
{
    html_form_borrar="<div id='borrar' class='centrado'><form onsubmit='event.preventDefault();hacer_borrar();'>";
    html_form_borrar+="<p><label for='usuario'>Introduce el codigo a borrar </label><input type='text' id='idProducto' required/></p>";
    html_form_borrar+="<p><label for='clave'>Contraseña: </label><input onkeyup='cifrar_clave();' type='password' id='clave' required/><input id='clave2' type='hidden'/></p>";
    html_form_borrar+="</form></div>";

    $('#principal').html(html_form_borrar);
}
})