<?php


class Empleado{

    private $nombre;
    private $sueldo;

    public function __construct($nuevo_nombre,$nuevo_sueldo){
        $this->nombre=$nuevo_nombre;
        $this->sueldo=$nuevo_sueldo;
    }

    public function impuestos(){
        if($this->get_sueldo()>3000){
            echo "El empleado ".$this->get_nombre()." debe pagar impuestos";
        }else{
            echo "El empleado ".$this->get_nombre()." no debe pagar impuestos";
        }
    }
   
    public function set_nombre($nombre_nuevo){
        $this->nombre=$nombre_nuevo;
    }

    public function set_sueldo($sueldo_nuevo){
        $this->sueldo=$sueldo_nuevo;
    }

    public function get_nombre(){
        return $this->nombre;
    }

    public function get_sueldo(){
        return $this->sueldo;
    }

}




?>