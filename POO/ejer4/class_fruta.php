<?php
    class Fruta{
        private $color, $tamanio;
        private static $nFrutas = 0;

        public function __construct($colorNuevo, $tamanioNuevo){
            $this ->color = $colorNuevo;
            $this -> tamanio =$tamanioNuevo;
            //$this -> $nFrutas++; // NO FUNCIONA PARA PROPIEDADES ESTATICAS
            self :: $nFrutas++;
        }

        public function __destruct(){
            self :: $nFrutas--;
        }

        public static function cuantaFruta(){
            return self :: $nFrutas;
        }


        public function setColor($colorNuevo){
            $this -> color = $colorNuevo;
        }

        public function setTamanio($tamanioNuevo){
            $this -> tamanio = $tamanioNuevo;
        }

        public function getColor(){
            return $this -> color;
        }
        public function getTamanio(){
            return $this -> tamanio;
        }

        public function imprimir(){
            echo "<p><strong>Color: </strong>" . $this -> getColor(). "<br><strong>Tamaño: </strong>" . $this->getTamanio() . "</p>";
        }
    }



?>






































