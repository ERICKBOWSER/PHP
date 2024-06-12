const DIR_SERV = "http://localhost/Proyectos/PHP/Curso23_24/PHPYJS/TeoriaAJAX/primera_api";

function llamada_get1()
{
    $.ajax({
        url:DIR_SERV+"/saludo",
        dataType:"json",
        type:"GET"
    })
    .done(function(data){

        $('#respuesta').html(data.mensaje);
    })

    .fail(function(a,b){
        $('#respuesta').html(error_ajax_jquery(a, b));
    });
    
}

function llamada_get2()
{
    var nombre="María José"
    $.ajax({
        url:encodeURI(DIR_SERV+"/saludo/"+nombre),
        dataType:"json",
        type:"GET"
    })
    .done(function(data){

        $('#respuesta').html(data.mensaje);
    })

    .fail(function(a,b){
        $('#respuesta').html(error_ajax_jquery(a, b));
    });
    
}

function llamada_post()
{
    var nombre="Juan José"
    $.ajax({
        url:DIR_SERV+"/saludo",
        dataType:"json",
        type:"POST",
        data:{"name":nombre}
    })
    .done(function(data){

        $('#respuesta').html(data.mensaje);
    })

    .fail(function(a,b){
        $('#respuesta').html(error_ajax_jquery(a, b));
    });
    
}

function llamada_delete()
{
    var id_borrar=5;
    $.ajax({
        url:DIR_SERV+"/borrar_saludo/"+id_borrar,
        dataType:"json",
        type:"DELETE"
    })
    .done(function(data){

        $('#respuesta').html(data.mensaje);
    })

    .fail(function(a,b){
        $('#respuesta').html(error_ajax_jquery(a, b));
    });
    
}

function llamada_put()
{
    var id_actualizar=5;
    var nuevo_nombre="Nuevo nombre";
    $.ajax({
        url:DIR_SERV+"/actualizar_saludo/"+id_actualizar,
        dataType:"json",
        type:"PUT",
        data:{"nombre":nuevo_nombre}
    })
    .done(function(data){

        $('#respuesta').html(data.mensaje);
    })

    .fail(function(a,b){
        $('#respuesta').html(error_ajax_jquery(a, b));
    });
    
}

function obtener_productos()
{
    $.ajax({
       
        url:"http://localhost/Proyectos/PHP/Curso23_24/Servicios/Ejercicios/Ejercicio1/servicios_rest/productos",
        dataType:"json",
        type:"GET"
    })
    .done(function(data){
        if(data.mensaje_error)
        {
            $('#respuesta').html(data.mensaje_error);
        }
        else
        {
            var tabla_productos="<table>";
            tabla_productos+="<tr><th>COD</th><th>Nombre Corto</th><th>PVP</th></tr>";
            $.each(data.productos,function(key,tupla){
                tabla_productos+="<tr>";
                tabla_productos+="<td>"+tupla["cod"]+"</td>";
                tabla_productos+="<td>"+tupla["nombre_corto"]+"</td>";
                tabla_productos+="<td>"+tupla["PVP"]+"</td>";
                tabla_productos+="</tr>";
            });
            tabla_productos+="</table>";
            $('#respuesta').html(tabla_productos);
        }
    })

    .fail(function(a,b){
        $('#respuesta').html(error_ajax_jquery(a, b));
    });
    
}

function error_ajax_jquery( jqXHR, textStatus) 
{
    var respuesta;
    if (jqXHR.status === 0) {
  
      respuesta='Not connect: Verify Network.';
  
    } else if (jqXHR.status == 404) {
  
      respuesta='Requested page not found [404]';
  
    } else if (jqXHR.status == 500) {
  
      respuesta='Internal Server Error [500].';
  
    } else if (textStatus === 'parsererror') {
  
      respuesta='Requested JSON parse failed.';
  
    } else if (textStatus === 'timeout') {
  
      respuesta='Time out error.';
  
    } else if (textStatus === 'abort') {
  
      respuesta='Ajax request aborted.';
  
    } else {
  
      respuesta='Uncaught Error: ' + jqXHR.responseText;
  
    }
    return respuesta;
}

$(document).ready(function(){
    obtener_productos();

});