<?php
    class Empleado{
        private $sueldo, $nombre;

        public function __construct(string $sueldoNuevo, string $nombreNuevo){
            $this -> sueldo = $sueldoNuevo;
            $this -> nombre = $nombreNuevo;
        }
        
        public function getSueldo(){
            return $this -> sueldo;
        }          

        public function getNombre(){
            return $this -> nombre;
        }          

        public function setSueldo($sueldoNuevo){
            $this -> sueldo = $sueldoNuevo;
        }

        public function setNombre($nombreNuevo){
            $this -> nombre = $nombreNuevo;
        }

        public function impuestos(){
            echo "<p>";
            echo "El empleado <strong>" . $this->nombre . "</strong> con sueldo: <strong>" . $this->sueldo . "</strong>";

            if($this->sueldo > 3000){
                echo "Tiene que pagar impuestos.</p>";
            }else{
                echo "No tiene que pagar impuestos.</p>"
            }

        }

        
        
    }


?>