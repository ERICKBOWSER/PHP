<?php
    require "class_fruta.php";

    class Uva extends Fruta{
        private $tieneSemilla;

        public function __construct($nuevoColor, $nuevoTamanio, $tiene){
            $this -> tieneSemilla = $tiene;

            parent :: __construct($nuevoColor, $nuevoTamanio, $tiene){
                $this -> $tieneSemilla = $tiene;
                
            }
            
        }

        public function tieneSemilla(){
            return $this -> tieneSemilla;
        }
    }

?>