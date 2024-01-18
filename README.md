<p align="center"> <img src="https://github.com/ERICKBOWSER/PHP/assets/92431188/598b984a-186d-4e15-b7b2-fbfd35fc4167" width=400px> </p>


## XAMPP

Iniciar servicios:

``sudo /opt/lampp/lampp start``

Parar servicios:

``sudo /opt/lampp/lampp stop``


## Importante

Para que salga el mensaje de error en la web.

Código: `sudo nano /opt/lampp/etc/php.ini`

![image](https://github.com/ERICKBOWSER/PHP/assets/92431188/8295e501-106c-42f3-a97e-2b595d25480d)

Hay que colocar el display_errors en On

![image](https://github.com/ERICKBOWSER/PHP/assets/92431188/1e10d0ed-fe23-40fb-a047-04a3c381c298)


Cuando dentro solo hay 1 sentencia no hace falta colocar llaves en el else.




![image](https://github.com/ERICKBOWSER/PHP/assets/92431188/35f09fc0-3e8e-4b79-baab-49ac356b0b04)


## Files

### Importante

Los daños no se guardan en $_POST sino en $_FILES 

---

El método de envío del formulario siempre tiene que ser POST y tiene que tener el enctype

---

Si no hay !getimagesize() devuelve 0

---

Por politica no se guardan las fotos, así que si se recarga la página no se guardan los datos.

---
ord("A");
chr(a)


##  Eliminar imagenes/links de la bbdd

Código: ``unlink("ruta/nombre.tipo");``

## ID de la última inserción de img
Código: ``mysqli_insert_id($conexion)``

``` function consumir_servicios_REST($url,$metodo,$datos=null)
    {
        $llamada=curl_init();
        curl_setopt($llamada,CURLOPT_URL,$url);
        curl_setopt($llamada,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($llamada,CURLOPT_CUSTOMREQUEST,$metodo);
        if(isset($datos))
            curl_setopt($llamada,CURLOPT_POSTFIELDS,http_build_query($datos));
        $respuesta=curl_exec($llamada);
        curl_close($llamada);
        return $respuesta;
    }```

























